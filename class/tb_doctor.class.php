<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_doctor
{
  private static $tb_name  = 'doctor';
  private static $all_cols = '*';

  public static function insert_new_one($phone_num,
                                        $passwd,
                                        $employe_id,
                                        $classify,
                                        $name,
                                        $sex,
                                        $icon_url,
                                        $ke_shi,
                                        $tec_title,
                                        $aca_title,
                                        $adm_title,
                                        $hospital,
                                        $expert_in,
                                        $c_time)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $name = $db->escape($name);
    $hospital = $db->escape($hospital);
    $expert_in = $db->escape($expert_in);
    $sql = "insert into "
      . self::$tb_name
      . "(phone_num,passwd,employe_id,classify,name,sex,icon_url,ke_shi,tec_title,aca_title,adm_title,hospital,expert_in,c_time)"
      . "value('$phone_num','$passwd','$employe_id',$classify,'$name',$sex,'$icon_url',$ke_shi,$tec_title,$aca_title,$adm_title,'$hospital','$expert_in',$c_time)";
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
  public static function query_doctor_total_num($where)
  {
    if (!empty($where)) {
      $where = " where $where";
    }
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*) from "
      . self::$tb_name
      . $where;
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) {
      return false;
    }
    return (int)$ret;
  }
  // return false on error, return array on ok.
  public static function query_doctor_by_id($id)
  {
    if (empty($id)) {
      return false;
    }
    // for cache
    $cc = new cache();
    $ck = CK_DOCTOR_ID_2_DOCTOR . $id;
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
  public static function query_doctor_limit($where,
                                            $order_by,
                                            $start,
                                            $offset)
  {
    if (!empty($where)) {
      $where = " where $where";
    }
    if (!empty($order_by)) {
      $order_by = " order by $order_by";
    }
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " {$where} {$order_by} limit {$start},{$offset}";
    return $db->get_rows($sql);
  }
};
