<?php

require_once ROOT . '/common/cc_key_def.php';

class tb_user
{
  private static $tb_name  = 'user';
  private static $all_cols = '*';

  public static function insert_new_one($phone_num, $passwd, $c_time)
  {
    $sql = "insert into "
      . self::$tb_name
      . "(phone_num,passwd,c_time)"
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
  public static function query_user_by_phone_num($phone_num)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
    . self::$all_cols
    . " from "
    . self::$tb_name
    . " where phone_num='$phone_num' limit 1";
    return $db->get_row($sql);
  }
  // return false on error, return array on ok.
  public static function query_user_by_id($id)
  {
    // for cache
    $cc = new cache();
    $ck = CK_USER_ID_2_USER . $id;
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
  public static function update_default_patient($user_id, $patient_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "update "
    . self::$tb_name
    . " set "
    . "default_patient=$patient_id"
    . " where id=$user_id limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }

    // for cache
    $cc = new cache();
    $ck = CK_USER_ID_2_USER . $id;
    $result = $cc->del($ck);

    return true;
  }
};
