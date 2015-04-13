<?php

require_once ROOT . '/common/cc_key_def.php';

class tb_user_guan_zhu
{
  private static $tb_name  = 'user_guan_zhu';
  private static $all_cols = '*';

  public static function insert_new_one($user_id, $doctor_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "insert into "
      . self::$tb_name
      . "(user_id,doctor_id)"
      . "value({$user_id},{$doctor_id})";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_USER_GUAN_ZHU_LIST . $user_id;
      $cc->del($ck);
      return true;
    }
    return false;
  }
  public static function del_one($user_id, $doctor_id)
  {
    if (empty($user_id) || empty($doctor_id)) {
      return false;
    }
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "delete from "
      . self::$tb_name
      . " where user_id={$user_id} and doctor_id={$doctor_id}";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_USER_GUAN_ZHU_LIST . $user_id;
      $cc->del($ck);
    }
    return true;
  }

  public static function query_user_guan_zhu_num($user_id)
  {
    if (empty($user_id)) {
      return false;
    }
    // for cache
    $cc = new cache();
    $ck = CK_USER_GUAN_ZHU_LIST . $user_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      return count(json_decode($result, true));
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*)"
      . " from "
      . self::$tb_name
      . " where user_id={$user_id}";
    return $db->get_rows_count($sql);
  }
  // return false on error, return array on ok.
  public static function query_user_guan_zhu_list($user_id)
  {
    if (empty($user_id)) {
      return false;
    }
    // for cache
    $cc = new cache();
    $ck = CK_USER_GUAN_ZHU_LIST . $user_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      return json_decode($result, true);
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select doctor_id from "
      . self::$tb_name
      . " where user_id={$user_id}";
    $result = $db->get_rows($sql);

    // for cache
    if ($result !== false) {
      $cc->set($ck, json_encode($result));
    }
    return $result;
  }
  public static function query_user_had_guan_zhu_or_not($user_id, $doctor_id)
  {
    if (empty($user_id) || empty($doctor_id)) {
      return true;
    }
    // for cache
    $cc = new cache();
    $ck = CK_USER_GUAN_ZHU_LIST . $user_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      $result = json_decode($result, true);
      if (in_array($doctor_id, $result)) {
        return true;
      }
      return false;
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select 1 from "
      . self::$tb_name
      . " where user_id={$user_id} and doctor_id={$doctor_id}";
    return $db->get_rows_count($sql) == 1;
  }
};
