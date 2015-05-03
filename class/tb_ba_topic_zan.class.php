<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_ba_topic_zan
{
  private static $tb_name  = 'ba_topic_zan';
  private static $all_cols = '*';

  public static function insert_new_one($topic_id, $user_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "insert into "
      . self::$tb_name
      . "(topic_id,user_id)"
      . "value($topic_id,$user_id)";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      return $db->get_insert_id();
    }
    return false;
  }
  public static function del_one($topic_id, $user_id)
  {
    if (empty($topic_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "delete from "
      . self::$tb_name
      . " where topic_id=$topic_id and user_id=$user_id limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }
    return $db->affected_rows() == 1 ? 1 : 0;
  }
  public static function user_had_zan($topic_id, $user_id)
  {
    if (empty($topic_id) || empty($user_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "select 1 from "
      . self::$tb_name
      . " where topic_id=$topic_id and user_id=$user_id limit 1";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) { return false; }
    return $ret == '1';
  }
};
