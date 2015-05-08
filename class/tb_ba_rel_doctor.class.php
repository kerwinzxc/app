<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_ba_rel_doctor
{
  private static $tb_name  = 'ba_rel_doctor';
  private static $all_cols = '*';

  public static function update($ba_id, $doctor_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "replace into "
      . self::$tb_name
      . "(ba_id,doctor_id)"
      . "value($ba_id,$doctor_id)";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() >= 1) {
      // for cache
      $cc = new cache();
      $ck = CK_BA_REL_DOCTOR_LIST . $ba_id;
      $cc->del($ck);

      return $db->get_insert_id();
    }
    return false;
  }
  public static function del_one($ba_id, $doctor_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "delete from "
      . self::$tb_name
      . " where ba_id={$ba_id} and doctor_id={$doctor_id} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }

    // for cache
    $cc = new cache();
    $ck = CK_BA_REL_DOCTOR_LIST . $ba_id;
    $cc->del($ck);

    return true;
  }
  public static function query_doctor_rel_ba($doctor_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select ba_id from "
      . self::$tb_name
      . " where doctor_id={$doctor_id} limit 1";
    return $db->get_row($sql);
  }
  public static function query_ba_rel_doctor_list($ba_id)
  {
    // for cache
    $cc = new cache();
    $ck = CK_BA_REL_DOCTOR_LIST . $ba_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      return json_decode($result, true);
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select doctor_id from "
      . self::$tb_name
      . " where ba_id={$ba_id}";
    $result = $db->get_rows($sql);

    // for cache
    if (!empty($result)) {
      $cc->set($ck, json_encode($result));
    }
    return $result;
  }
};
