<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_doctor_introduction
{
  private static $tb_name  = 'doctor_introduction';
  private static $all_cols = '*';

  public static function update($doctor_id, $content)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $content = $db->escape($content);
    $sql = "replace into "
      . self::$tb_name
      . "(doctor_id,content)"
      . "value($doctor_id,'$content')";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() >= 1) {
      // for cache
      $cc = new cache();
      $ck = CK_DOCTOR_ID_2_INTRODUCTION . $doctor_id;
      $cc->del($ck);

      return true;
    }
    return false;
  }

  // return false on error, return array on ok.
  public static function query_introduction_by_doctor_id($doctor_id)
  {
    if (empty($doctor_id)) { return false; }

    // for cache
    $cc = new cache();
    $ck = CK_DOCTOR_ID_2_INTRODUCTION . $doctor_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      return json_decode($result, true);
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " where doctor_id=$doctor_id limit 1";
    $result = $db->get_row($sql);

    // for cache
    if ($result !== false) {
      $cc->set($ck, json_encode($result));
    }
    return $result;
  }
};
