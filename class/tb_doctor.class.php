<?php

class tb_doctor
{
  private static $tb_name  = 'doctor';
  private static $all_cols = '*';

  public static function insert_new_one($phone_num, $passwd, $c_time)
  {
    $sql = "insert into "
      . self::$tb_name
      . "(uid,phone_num,passwd,c_time)"
      . "value($phone_num,'$passwd',$c_time)";
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      return $db->get_insert_id();
    }
    return false;
  }

  // return false on error, return array on ok.
  public static function query_doctor_by_phone_num($phone_num)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
    . self::$all_cols
    . " from "
    . self::$tb_name
    . " where phone_num='$phone_num' limit 1";
    return $db->get_row($sql);
  }
};
