<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_user_gz_doctor
{
  private static $tb_name  = 'user_gz_doctor';
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
      $ck = CK_USER_GZ_DOCTOR_LIST . $user_id;
      $cc->del($ck);
      return true;
    }
    return false;
  }
  public static function del_one($user_id, $doctor_id)
  {
    if (empty($user_id) || empty($doctor_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "delete from "
      . self::$tb_name
      . " where user_id={$user_id} and doctor_id={$doctor_id} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_USER_GZ_DOCTOR_LIST . $user_id;
      $cc->del($ck);
      return 1;
    }
    return 0;
  }

  public static function query_user_guan_zhu_num($user_id)
  {
    if (empty($user_id)) { return false; }

    // for cache
    $cc = new cache();
    $ck = CK_USER_GZ_DOCTOR_LIST . $user_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      return count(json_decode($result, true));
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*)"
      . " from "
      . self::$tb_name
      . " where user_id={$user_id}";
    return (int)$db->get_one_row_col($sql, 0);
  }
  // return false on error, return array(12,1,2).
  public static function query_user_guan_zhu_list($user_id)
  {
    if (empty($user_id)) { return false; }

    // for cache
    $cc = new cache();
    $ck = CK_USER_GZ_DOCTOR_LIST . $user_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      return json_decode($result, true);
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select doctor_id from "
      . self::$tb_name
      . " where user_id={$user_id}";
    $result = $db->get_rows($sql);

    if ($result !== false) {
      $result = array_map(function ($r) { return (int)$r['doctor_id'];}, $result);
      // for cache
      $cc->set($ck, json_encode($result));
    }
    return $result;
  }
  public static function query_user_had_guan_zhu_or_not($user_id, $doctor_id)
  {
    if (empty($user_id) || empty($doctor_id)) { return true; }

    $doctor_id = (int)$doctor_id;
    // for cache
    $cc = new cache();
    $ck = CK_USER_GZ_DOCTOR_LIST . $user_id;
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
    return $db->get_one_row_col($sql, 0) == '1';
  }
};
