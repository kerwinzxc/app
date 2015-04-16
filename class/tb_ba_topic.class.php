<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_ba_topic
{
  private static $tb_name  = 'ba_topic';
  private static $all_cols = '*';

  public static function insert_new_one($ba_id,
                                        $user_id,
                                        $title,
                                        $c_time)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $title = $db->escape($title);
    $sql = "insert into "
      . self::$tb_name
      . "(ba_id,user_id,title,c_time)"
      . "value($ba_id,$user_id,'$title',$c_time)";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      return $db->get_insert_id();
    }
    return false;
  }
  public static function del_one($topic_id)
  {
    if (empty($topic_id)) {
      return false;
    }
    $db = new sql(db_selector::get_db(db_selector::$db_2));
    $sql = "delete from "
      . self::$tb_name
      . " where id=$topic_id limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }
    return $db->affected_rows() == 1) ? 1 : 0;
  }

  public static function query_topic_total_num($ba_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*) from "
      . self::$tb_name
      . " where ba_id=$ba_id";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) {
      return false;
    }
    return (int)$ret;
  }
  // return false on error, return array on ok.
  public static function query_topic_by_id($id)
  {
    if (empty($id)) {
      return false;
    }
    // for cache
    $cc = new cache();
    $ck = CK_TOPIC_ID_2_TOPIC . $id;
    $result = $cc->get($ck);
    if ($result !== false) {
      return json_decode($result, true);
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
    . self::$all_cols
    . " from "
    . self::$tb_name
    . " where id=$id limit 1";
    $result = $db->get_row($sql);

    // for cache
    if ($result !== false) {
      $cc->set($ck, json_encode($result));
    }
    return $result;
  }
  public static function query_topic_brief_limit($where,
                                                 $order_by,
                                                 $start,
                                                 $offset)
  {
    if (!empty($where)) {
      $where = " where $where";
    }
    if (!empty($order_by)) {
      $order_by = " order by $order_by";
    }
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select * from "
      . self::$tb_name
      . " {$where} {$order_by} limit {$start},{$offset}";
    return $db->get_rows($sql);
  }
};
