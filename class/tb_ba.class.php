<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_ba
{
  private static $tb_name  = 'ba';
  private static $all_cols = '*';

  public static function insert_new_one($priority,
                                        $name,
                                        $desc,
                                        $icon_url)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $name = $db->escape($name);
    $desc = $db->escape($desc);
    $sql = "insert into "
      . self::$tb_name
      . "(priority,name,ba_desc,icon_url)"
      . "value($priority,'$name','$desc','$icon_url')";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_ALL_BA_SHOW_LIST;
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
    $ck = CK_ALL_BA_SHOW_LIST;
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
    $ck = CK_ALL_BA_SHOW_LIST;
    $cc->del($ck);

    return true;
  }

  public static function query_ba_total_num()
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
  public static function query_ba_by_id($id)
  {
    if (empty($id)) { return false; }

    // for cache
    $cc = new cache();
    $ck = CK_BA_ID_2_INFO . $id;
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
    $ret = $db->get_row($sql);

    // for cache
    if (!empty($ret)) {
      $cc->set($ck, json_encode($ret));
    }
    return $ret;
  }
  public static function query_ba_name_exist_or_not($name)
  {
    if (empty($name)) { return true; }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select 1 from "
      . self::$tb_name
      . " where name='{$name}' limit 1";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) return false;
    return $ret == '1';
  }
  public static function query_ba_all_open_list()
  {
    // for cache
    $cc = new cache();
    $ck = CK_ALL_BA_SHOW_LIST;
    $result = $cc->get($ck);
    if ($result !== false) {
      return json_decode($result, true);
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " where open=1 order by priority asc";
    $result = $db->get_rows($sql);

    // for cache
    if (!empty($result)) {
      $cc->set($ck, json_encode($result));
    }
    return $result;
  }
  public static function query_ba_limit($start, $offset)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " order by priority asc limit {$start},{$offset}";
    return $db->get_rows($sql);
  }
};
