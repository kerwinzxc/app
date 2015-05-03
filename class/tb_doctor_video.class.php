<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_doctor_video
{
  private static $tb_name  = 'doctor_video';
  private static $all_cols = '*';

  public static function insert_new_one($doctor_id,
                                        $topic,
                                        $video_url,
                                        $c_time)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $topic = $db->escape($topic);
    $video_url = $db->escape($video_url);
    $sql = "insert into "
      . self::$tb_name
      . "(doctor_id,topic,video_url,c_time)"
      . "value($doctor_id,'$topic','$video_url',$c_time)";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      return $db->get_insert_id();
    }
    return false;
  }
  public static function del_one($id, $doctor_id)
  {
    if (empty($id) || empty($doctor_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "delete from "
      . self::$tb_name
      . " where id=$id and doctor_id=$doctor_id limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }
    return $db->affected_rows() == 1 ? 1 : 0;
  }

  // return false on error, return array on ok.
  public static function query_video_by_id($id)
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
  // return false on error, return array on ok.
  public static function query_video_by_doctor_id($doctor_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " where doctor_id=$doctor_id";
    return $db->get_rows($sql);
  }
  public static function query_video_total_num($doctor_id)
  {
    if (empty($doctor_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*) from "
      . self::$tb_name
      . " where doctor_id=$doctor_id";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) { return false; }
    return (int)$ret;
  }
  public static function query_video_limit($where,
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
