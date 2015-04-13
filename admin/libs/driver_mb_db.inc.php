<?php

require_once ROOT . 'libs/db_abstract.inc.php';
require_once ROOT . 'libs/func.inc.php';
require_once ROOT . 'api/cache.class.php';

class driver_mb_db extends db_abstract
{
  //=
  function __construct()
  {
    if (get_current_user() == 'sparkcui')
      parent::__construct("utruck", "127.0.0.1:3306", "root", "shaovie");
    else
      parent::__construct("utruck", "192.168.1.220:3308", "han", "gh78dp");
  }

  public static function query_driver_by_phone_num($phone_num)
  {
    $cc_key = "phone_num:driver=" . $phone_num;
    $cc_v = cache::get($cc_key);
    if ($cc_v !== false)
      return json_decode($cc_v, true);

    $db = new driver_mb_db();
    $result = $db->query("select uid,phone_num,lng,lat from driver where phone_num='$phone_num' limit 1");
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);
    if (empty($rows)) return array();

    cache::set($cc_key, json_encode($rows[0]));
    return $rows[0];
  }
  public static function update_driver_coord($phone_num, $lng, $lat)
  {
    $db = new driver_mb_db();
    $result = $db->query("update driver set lng=$lng,lat=$lat where phone_num='$phone_num' limit 1");
    if ($result === false)
      return false;
    $ret = mysql_affected_rows();
    if ($ret == -1) return false;
    cache::del("phone_num:driver=" . $phone_num);
    return true;
  }
  public static function select_order($lmt)
  {
    $cc_key = "newst_order_list=";
    $cc_v = cache::get($cc_key);
    if ($cc_v !== false)
    {
      $cc_v = json_decode($cc_v, true);
      $nt = cache::get('newest_order_time');
      if ($nt === false || $nt < $cc_v['t'])
        return $cc_v['v'];
    }
      
    $db = new driver_mb_db();
    $colums = "order_id,uid,c_time,status,goods_type,goods_weight,from_city,to_city,truck_classify,truck_length,load_time,orig_price";
    $result = $db->query("select $colums from yun_dan order by c_time desc limit $lmt");
    if ($result === false)
      return false;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);

    $cc_v = array('t' => time(), 'v' => $rows);
    cache::set($cc_key, json_encode($cc_v));
    return $rows;
  }
  public static function select_lbs_order($lng, $lat)
  {
    $cc_key = "coord:orders=" . $lng . ';' . $lat;
    $cc_v = cache::get($cc_key);
    if ($cc_v !== false)
    {
      $cc_v = json_decode($cc_v, true);
      $nt = cache::get('newest_order_time');
      if ($nt === false || $nt < $cc_v['t'])
        return $cc_v['v'];
    }
      
    $db = new driver_mb_db();
    $diff = (double)0.9;
    $lng  = (double)$lng;
    $lat  = (double)$lat;
    $min_lng = $lng - $diff;
    $max_lng = $lng + $diff;
    $min_lat = $lat - $diff;
    $max_lat = $lat + $diff;
    $colums = "order_id,uid,c_time,status,goods_type,goods_weight,from_city,to_city,truck_classify,truck_length,load_time,orig_price";
    $result = $db->query("select $colums from yun_dan where (lng between $min_lng and $max_lng) and (lat between $min_lat and $max_lat) order by sqrt(power(abs($lat-lat),2)+power(abs($lng-lng),2)) limit 10");
    if ($result === false)
      return false;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);

    $cc_v = array('t' => time(), 'v' => $rows);
    cache::set($cc_key, json_encode($cc_v));
    return $rows;
  }
  public static function insert_yun_dan($order_id,
    $uid,
    $lng,
    $lat)
  {
    $db = new driver_mb_db();
    $result = $db->query("insert into yun_dan(order_id,uid,lng,lat)values('$order_id',$uid,$lng,$lat)");
    if ($result === false)
     return false;
    $ret = mysql_affected_rows();
    return $ret == -1 ? false : true;
  }
  public static function query_order_by_id($order_id)
  {
    $cc_key = "order_id:info=" . $order_id;
    $cc_v = cache::get($cc_key);
    if ($cc_v !== false)
      return json_decode($cc_v, true);

    $db = new driver_mb_db();
    $result = $db->query("select * from yun_dan where order_id='$order_id' limit 1");
    if ($result === false)
      return false;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);
    if (empty($rows)) return array();

    cache::set($cc_key, json_encode($rows[0]));
    return $rows[0];
  }
  public static function insert_yun_dan_bid($order_id,
    $uid,
    $bid_time,
    $bid_price)
  {
    $db = new driver_mb_db();
    $result = $db->query("insert into yun_dan_bid(order_id,uid,bid_time,bid_price)values('$order_id',$uid,$bid_time,$bid_price)");
    if ($result === false) return false;
    $ret = mysql_affected_rows();
    return $ret == -1 ? false : true;
  }
  public static function select_yun_dan_my_bid_list($uid)
  {
    $db = new driver_mb_db();
    $colums = "order_id,uid,bid_time,bid_price";
    $result = $db->query("select $colums from yun_dan_bid where uid=$uid order by bid_time desc limit 15");
    if ($result === false)
      return false;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);

    return $rows;
  }
};
