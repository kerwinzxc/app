<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_feedback
{
  private static $tb_name  = 'feedback';
  private static $all_cols = '*';

  public static function insert_new_one($user_id,
                                        $content,
                                        $time)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $content = $db->escape($content);
    $sql = "insert into "
      . self::$tb_name
      . "(user_id,content,c_time)"
      . "value($user_id,'$content',$c_time)";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      return $db->get_insert_id();
    }
    return false;
  }

  public static function query_total_num()
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*) from "
      . self::$tb_name;
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) {
      return false;
    }
    return (int)$ret;
  }
  public static function query_limit($start, $offset)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " limit {$start},{$offset}";
    return $db->get_rows($sql);
  }
};
