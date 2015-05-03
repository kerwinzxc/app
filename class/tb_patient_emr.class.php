<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_patient_emr
{
  private static $tb_name  = 'patient_emr';
  private static $all_cols = '*';

  public static function insert_new_one($user_id,
                                        $patient_id,
                                        $sd_time,
                                        $hospital,
                                        $ke_shi,
                                        $doctor_name,
                                        $photoes_1,
                                        $photoes_2,
                                        $doctor_diagnosis,
                                        $doctor_tell)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $hospital = $db->escape($hospital);
    $ke_shi = $db->escape($ke_shi);
    $doctor_name = $db->escape($doctor_name);
    $doctor_diagnosis = $db->escape($doctor_diagnosis);
    $doctor_tell = $db->escape($doctor_tell);
    $sql = "insert into "
      . self::$tb_name
      . "(user_id,patient_id,sd_time,hospital,ke_shi,doctor_name,photoes_1,photoes_2,doctor_diagnosis,doctor_tell)"
      . "value($user_id,$patient_id,$sd_time,'$hospital','$ke_shi','$doctor_name','$photoes_1','$photoes_2','$doctor_diagnosis','$doctor_tell')";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      return $db->get_insert_id();
    }
    return false;
  }
  public static function del_one($emr_id, $user_id)
  {
    if (empty($emr_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "delete from "
      . self::$tb_name
      . " where id={$emr_id} and user_id={$user_id} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }
    return $db->affected_rows() == 1 ? 1 : 0;
  }

  // return false on error, return array on ok.
  public static function query_emr_by_id($id)
  {
    if (empty($id)) { return false; }

    // for cache
    $cc = new cache();
    $ck = CK_PATIENT_EMR_ID_2_EMR . $id;
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
  public static function query_patient_emrs_num($patient_id)
  {
    if (empty($patient_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*)"
      . " from "
      . self::$tb_name
      . " where patient_id={$patient_id}";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) return false;
    return (int)$ret;
  }
  // return false on error, return array on ok.
  public static function query_patient_emr_limit($patient_id,
                                                 $start,
                                                 $offset)
  {
    if (empty($patient_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " where patient_id={$patient_id} limit {$start},{$offset}";
    return $db->get_rows($sql);
  }
};
