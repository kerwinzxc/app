<?php

require_once ROOT . 'libs/db_abstract.inc.php';
require_once ROOT . 'libs/func.inc.php';

class crm_db extends db_abstract
{
  //=
  function __construct()
  {
    if (get_current_user() == 'sparkcui')
      parent::__construct("utruck", "127.0.0.1:3306", "root", "zhongwei");
    else
      parent::__construct("utruck", "192.168.1.220:3308", "han", "gh78dp");
  }

  //
  public static function reg_user_is_exist($user)
  {
    $db = new crm_db();
    $user = escape_input($user);
    $result = $db->query("select 1 from employe where uid='$user' limit 1");
    if ($result && mysql_num_rows($result) > 0)
    {
      mysql_free_result($result); 
      return true;
    }
    return false;
  }
  public static function insert_employe($user, $name)
  {
    $db = new crm_db();
    $passwd = md5("123456");
    $name = escape_input($name);
    $c_time = time();
    $result = $db->query("insert into employe(uid,passwd,name,c_time,in_time)"
      . "values('$user','$passwd','$name',$c_time,0)");
    return $result === false ? false : true;
  }
  public static function get_employe_name($user)
  {
    $db = new crm_db();
    $user = escape_input($user);
    $result = $db->query("select name from employe where uid='$user' limit 1");
    if ($result === false)
      return false;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);
    if (count($rows) == 0)
      return false;
    return $rows[0]['name'];
  }
  public static function update_employe($user, $name, $passwd)
  {
    $db = new crm_db();
    $name = escape_input($name);
    $passwd = md5($passwd);
    $result = $db->query("update employe set passwd='$passwd',name='$name' where uid='$user'");
    return $result === false ? false : true;
  }

  public static function login_auth($user, $passwd)
  {
    $user = escape_input($user);
    $passwd = md5($passwd);
    $db = new crm_db();
    $result = $db->query("select 1 from employe where "
      . "uid='$user' and passwd='$passwd' limit 1");
    if ($result && mysql_num_rows($result) > 0)
    {
      mysql_free_result($result); 
      return true;
    }
    return false;
  }

  public static function truck_is_exist($truck_id)
  {
    $db = new crm_db();
    $truck_id = escape_input($truck_id);
    $result = $db->query("select 1 from driver where truck_id='$truck_id' limit 1");
    if ($result && mysql_num_rows($result) > 0)
    {
      mysql_free_result($result); 
      return true;
    }
    return false;
  }
  public static function driver_is_exist($phone_num)
  {
    $db = new crm_db();
    $result = $db->query("select 1 from driver where phone_num='$phone_num' limit 1");
    if ($result && mysql_num_rows($result) > 0)
    {
      mysql_free_result($result); 
      return true;
    }
    return false;
  }
  public static function get_last_driver_id()
  {
    $db = new crm_db();
    $result = $db->query("insert into driver_id_pool()value()");
    if ($result === false)
      return 0;
    return mysql_insert_id();
  }
  public static function insert_driver(
    $uid,
    $name,
    $phone_num,
    $auth,
    $id_card,
    $truck_id,
    $classify,
    $payload,
    $length,
    $truck_zm_photo,
    $truck_cm_photo,
    $jsz_photo,
    $xsz_photo,
    $cyzgz_photo,
    $dangerous_cyzgz_photo,
    $employe_id)
  {
    $db = new crm_db();
    $name = escape_input($name);
    $passwd = md5('123456');
    $c_time = time();
    $result = $db->query("insert into driver(uid,passwd,name,phone_num,id_card,auth,truck_id,classify,payload,length,truck_zm_photo,truck_cm_photo,jsz_photo,xsz_photo,cyzgz_photo,dangerous_cyzgz_photo,employe_id,c_time)"
      . "values($uid,'$passwd','$name','$phone_num','$id_card',$auth,'$truck_id','$classify','$payload','$length','$truck_zm_photo','$truck_cm_photo','$jsz_photo','$xsz_photo','$cyzgz_photo','$dangerous_cyzgz_photo','$employe_id',$c_time)");
    return $result === false ? false : true;
  }
  public static function select_truck_count()
  {
    $db = new crm_db();
    $result = $db->query("select count(*) as count from driver");
    if ($result === false)
      return 0;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);
    return $rows[0]['count'];
  }
  public static function select_truck($start)
  {
    $db = new crm_db();
    $result = $db->query("select uid,truck_id,name,phone_num,employe_id,classify,c_time from driver order by uid desc limit $start,10");
    if ($result === false)
      return false;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);
    return $rows;
  }
  public static function query_truck_by_uid($uid)
  {
    $db = new crm_db();
    $result = $db->query("select name,phone_num,id_card,truck_id,classify,payload,length,truck_zm_photo,truck_cm_photo,jsz_photo,xsz_photo,cyzgz_photo,dangerous_cyzgz_photo,employe_id from driver where uid=$uid limit 1");
    if ($result === false)
      return false;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);
    return $rows;
  }
  public static function query_truck($where, $start)
  {
    $db = new crm_db();
    $result = $db->query("select uid,truck_id,name,phone_num,employe_id,classify,c_time from driver where $where order by uid desc limit $start,10");
    if ($result === false)
      return false;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);
    return $rows;
  }
  public static function del_truck($uid)
  {
    $db = new crm_db();
    $result = $db->query("delete from driver where uid=$uid limit 1");
    if ($result === false)
      return false;
    $ret = mysql_affected_rows();
    return $ret == -1 ? 0 : $ret;
  }

  public static function shipper_is_exist($phone_num)
  {
    $db = new crm_db();
    $result = $db->query("select 1 from shipper where phone_num='$phone_num' limit 1");
    if ($result && mysql_num_rows($result) > 0)
    {
      mysql_free_result($result); 
      return true;
    }
    return false;
  }
  public static function get_last_shipper_id()
  {
    $db = new crm_db();
    $result = $db->query("insert into shipper_id_pool()value()");
    if ($result === false)
      return 0;
    return mysql_insert_id();
  }
  public static function insert_shipper(
    $uid,
    $linkman,
    $phone_num,
    $ent_name,
    $address,
    $ent_desc,
    $bl_photo,
    $employe_id,
    $auth)
  {
    $db = new crm_db();
    $linkman = escape_input($linkman);
    $ent_name = escape_input($ent_name);
    $address = escape_input($address);
    $ent_desc = escape_input($ent_desc);
    $c_time = time();
    $passwd = md5('123456');
    $result = $db->query("insert into shipper(uid,passwd,linkman,phone_num,ent_name,address,ent_desc,bl_photo,employe_id,c_time,auth)"
      . "values($uid,'$passwd','$linkman','$phone_num','$ent_name','$address','$ent_desc','$bl_photo','$employe_id',$c_time,$auth)");
    return $result === false ? false : true;
  }
  public static function select_shipper_count()
  {
    $db = new crm_db();
    $result = $db->query("select count(*) as count from shipper");
    if ($result === false)
      return 0;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);
    return $rows[0]['count'];
  }
  public static function select_shipper($start)
  {
    $db = new crm_db();
    $result = $db->query("select uid,linkman,phone_num,ent_name,address,employe_id,c_time from shipper order by uid desc limit $start,10");
    if ($result === false)
      return false;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);
    return $rows;
  }
  public static function query_shipper_by_uid($uid)
  {
    $db = new crm_db();
    $result = $db->query("select uid,linkman,phone_num,ent_name,address,ent_desc,bl_photo,employe_id from shipper where uid=$uid limit 1");
    if ($result === false)
      return false;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);
    return $rows;
  }
  public static function query_shipper($where)
  {
    $db = new crm_db();
    $result = $db->query("select uid,linkman,phone_num,ent_name,address,employe_id,c_time from shipper where $where order by uid desc limit 10");
    if ($result === false)
      return false;
    $rows = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      $rows[] = $row;
    mysql_free_result($result);
    return $rows[0];
  }
  public static function del_shipper($uid)
  {
    $db = new crm_db();
    $result = $db->query("delete from shipper where uid=$uid limit 1");
    if ($result === false)
      return false;
    $ret = mysql_affected_rows();
    echo $ret;
    return $ret == -1 ? 0 : $ret;
  }
};
