<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_disease
{
  private static $tb_name  = 'disease';
  private static $all_cols = '*';

  public static function insert_new_one($name)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $name = $db->escape($name);
    $sql = "insert into "
      . self::$tb_name
      . "(name)"
      . "value('$name')";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_ALL_DISEASE_LIST;
      $cc->del($ck);

      return $db->get_insert_id();
    }
    return false;
  }
  public static function update($id, $update_info)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "update "
      . self::$tb_name
      . " set " . $db->get_set($update_info)
      . " where id={$id} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }

    // for cache
    $cc = new cache();
    $ck = CK_ALL_DISEASE_LIST;
    $cc->del($ck);

    return true;
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
    $ck = CK_ALL_DISEASE_LIST;
    $cc->del($ck);

    return true;
  }

  public static function query_all()
  {
    // for cache
    $cc = new cache();
    $ck = CK_ALL_DISEASE_LIST;
    $result = $cc->get($ck);
    if ($result !== false) {
      return json_decode($result, true);
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name;
    $ret = $db->get_rows($sql);

    if (!empty($ret)) {
      $cc->set($ck, json_encode($ret));
    }
    return $ret;
  }
  public static function query_disease_total_num()
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*) from "
      . self::$tb_name;
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) {
      return false;
    }
    return (int)$ret;
  }
  // return false on error, return array on ok.
  public static function query_disease_by_id($id)
  {
    if (empty($id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
    . self::$all_cols
    . " from "
    . self::$tb_name
    . " where id=$id limit 1";
    return $db->get_row($sql);
  }
  public static function query_limit($start, $offset)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " order by id asc limit {$start},{$offset}";
    return $db->get_rows($sql);
  }
};
