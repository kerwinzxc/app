<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_disease_rel_doctor
{
  private static $tb_name  = 'disease_rel_doctor';
  private static $all_cols = '*';

  public static function update($disease_id, $doctor_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "replace into "
      . self::$tb_name
      . "(disease_id,doctor_id)"
      . "value($disease_id,$doctor_id)";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() >= 1) {
      // for cache
      $cc = new cache();
      $ck = CK_DISEASE_REL_DOCTOR_LIST . $disease_id;
      $cc->del($ck);

      return $db->get_insert_id();
    }
    return false;
  }
  public static function del_one($disease_id, $doctor_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "delete from "
      . self::$tb_name
      . " where disease_id={$disease_id} and doctor_id={$doctor_id} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }

    // for cache
    $cc = new cache();
    $ck = CK_DISEASE_REL_DOCTOR_LIST . $disease_id;
    $cc->del($ck);

    return true;
  }
  public static function query_doctor_rel_disease($doctor_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select disease_id from "
      . self::$tb_name
      . " where doctor_id={$doctor_id}";
    return $db->get_rows($sql);
  }
  public static function query_disease_rel_doctor_list($disease_id)
  {
    // for cache
    $cc = new cache();
    $ck = CK_DISEASE_REL_DOCTOR_LIST . $disease_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      return json_decode($result, true);
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select doctor_id from "
      . self::$tb_name
      . " where disease_id={$disease_id}";
    $result = $db->get_rows($sql);

    // for cache
    if (!empty($result)) {
      $cc->set($ck, json_encode($result));
    }
    return $result;
  }
  public static function query_doctor_total_num($disease_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*) from "
      . self::$tb_name
      . " where disease_id=$disease_id";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) {
      return false;
    }
    return (int)$ret;
  }
  public static function query_doctor_limit($disease_id, $start, $offset)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . "doctor_id"
      . " from "
      . self::$tb_name
      . " where disease_id=$disease_id limit {$start},{$offset}";
    return $db->get_rows($sql);
  }
};
