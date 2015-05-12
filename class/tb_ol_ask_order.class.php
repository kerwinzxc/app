<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_ol_ask_order
{
  private static $tb_name  = 'ol_ask_order';
  private static $all_cols = '*';

  public static function insert_new_one($user_id,
                                        $doctor_id,
                                        $name,
                                        $sex,
                                        $id_card,
                                        $phone_num,
                                        $disease_desc,
                                        $expected_time_b,
                                        $expected_time_e,
                                        $emr_url,
                                        $c_time)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $disease_desc = $db->escape($disease_desc);
    $sql = "insert into "
      . self::$tb_name
      . "(user_id,doctor_id,name,sex,id_card,phone_num,disease_desc,expected_time_b,expected_time_e,emr_url,c_time)"
      . "value($user_id,$doctor_id,'$name',$sex,'$id_card','$phone_num','$disease_desc',$expected_time_b,$expected_time_e,'$emr_url',$c_time)";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      return $db->get_insert_id();
    }
    return false;
  }
  public static function del_one($id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "delete from "
      . self::$tb_name
      . " where id={$id} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }

    // for cache
    $cc = new cache();
    $ck = CK_OL_ASK_ORDER;
    $cc->del($ck);

    return true;
  }

  // return false on error, return array on ok.
  public static function query_order_by_id($id)
  {
    if (empty($id)) { return false; }

    // for cache
    $cc = new cache();
    $ck = CK_OL_ASK_ORDER . $id;
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
    if (!empty($result)) {
      $cc->set($ck, json_encode($result));
    }
    return $result;
  }
  public static function query_total_num($where)
  {
    if (!empty($where)) {
      $where = "where $where";
    }
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*)"
      . " from "
      . self::$tb_name
      . " $where";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) return false;
    return (int)$ret;
  }
  public static function query_order_num($user_id)
  {
    if (empty($user_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*)"
      . " from "
      . self::$tb_name
      . " where user_id={$user_id}";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) return false;
    return (int)$ret;
  }
  // return false on error, return array on ok.
  public static function query_limit($where, $start, $offset)
  {
    if (!empty($where)) {
      $where = "where $where";
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " $where order by id desc limit {$start},{$offset}";
    return $db->get_rows($sql);
  }
  // return false on error, return array on ok.
  public static function query_order_limit($user_id, $start, $offset)
  {
    if (empty($user_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " where user_id={$user_id} limit {$start},{$offset}";
    return $db->get_rows($sql);
  }
};
