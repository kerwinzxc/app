<?php

require_once ROOT . '/common/cc_key_def.php';

class tb_user_patient
{
  private static $tb_name  = 'user_patient';
  private static $all_cols = '*';

  public static function insert_new_one($user_id, $phone_num, $name, $sex)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $name = $db->escape($name);
    $sql = "insert into "
      . self::$tb_name
      . "(user_id,phone_num,name,sex)"
      . "value($user_id, $phone_num,'$name', $sex)";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_USER_PATIENT_LIST . $user_id;
      $cc->del($ck);

      return $db->get_insert_id();
    }
    return false;
  }
  public static function del_one($user_id, $patient_id)
  {
    if (empty($user_id) || empty($patient_id)) {
      return false;
    }
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $name = $db->escape($name);
    $sql = "delete from "
      . self::$tb_name
      . " where id={$patient_id} and user_id={$user_id}";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_USER_PATIENT_LIST . $user_id;
      $cc->del($ck);
    }
    return true;
  }

  public static function query_user_patients_num($user_id)
  {
    if (empty($user_id)) {
      return false;
    }
    // for cache
    $cc = new cache();
    $ck = CK_USER_PATIENT_LIST . $user_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      return count(json_decode($result, true));
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*)"
    . " from "
    . self::$tb_name
    . " where user_id=$user_id";
    return $db->get_rows_count($sql);
  }
  // return false on error, return array on ok.
  public static function query_user_patient_list($user_id)
  {
    if (empty($user_id)) {
      return false;
    }
    // for cache
    $cc = new cache();
    $ck = CK_USER_PATIENT_LIST . $user_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      return json_decode($result, true);
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
    . self::$all_cols
    . " from "
    . self::$tb_name
    . " where user_id=$user_id";
    $result = $db->get_rows($sql);

    // for cache
    if ($result !== false) {
      $cc->set($ck, json_encode($result));
    }
    return $result;
  }
};
