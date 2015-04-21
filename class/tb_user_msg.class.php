<?php

class tb_user_msg
{
  private static $tb_name  = 'user_msg';
  private static $all_cols = '*';

  public static function insert_new_one($user_id,
                                        $msg_type,
                                        $send_time,
                                        $title,
                                        $content,
                                        $c_time)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $title = $db->escape($title);
    $content = $db->escape($content);
    $sql = "insert into "
      . self::$tb_name
      . "(user_id,msg_type,send_time,title,content)"
      . "value($user_id,$msg_type,$send_time,'$title','$content')";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      return $db->get_insert_id();
    }
    return false;
  }
  public static function update($id, $info)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "update "
      . self::$tb_name
      . " set " . $db->get_set($info)
      . " where id={$doctor_id} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }

    return true;
  }

  // return false on error, return array on ok.
  public static function query_unread_num($user_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*) from "
      . self::$tb_name
      . " where user_id=$user_id and readed=0";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) {
      return false;
    }
    return (int)$ret;
  }
  public static function query_msg_detail_by_id($id)
  {
    if (empty($id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " where id=$id limit 1";
    return $db->get_row($sql);
  }
  public static function query_brief_limit($where,
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
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " {$where} {$order_by} limit {$start},{$offset}";
    return $db->get_rows($sql);
  }
};
