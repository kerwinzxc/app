<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_user_gz_ba
{
  private static $tb_name  = 'user_gz_ba';
  private static $all_cols = '*';

  public static function insert_new_one($user_id, $ba_id)
  {
    if (empty($ba_id)) { return true; }

    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "insert into "
      . self::$tb_name
      . "(user_id,ba_id)"
      . "value({$user_id},{$ba_id})";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() > 0) {
      // for cache
      $cc = new cache();
      $ck = CK_USER_GZ_BA_LIST . $user_id;
      $cc->del($ck);
      return true;
    }
    return false;
  }
  public static function del_one($user_id, $ba_id)
  {
    if (empty($user_id) || empty($ba_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "delete from "
      . self::$tb_name
      . " where user_id={$user_id} and ba_id={$ba_id} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_USER_GZ_BA_LIST . $user_id;
      $cc->del($ck);
      return 1;
    }
    return 0;
  }

  // return false on error, return array on ok.
  public static function query_user_guan_zhu_list($user_id)
  {
    if (empty($user_id)) { return false; }

    // for cache
    $cc = new cache();
    $ck = CK_USER_GZ_BA_LIST . $user_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      return json_decode($result, true);
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select ba_id from "
      . self::$tb_name
      . " where user_id={$user_id}";
    $result = $db->get_rows($sql);

    if ($result !== false) {
      $result = array_map(function ($r) { return (int)$r['ba_id'];}, $result);
      // for cache
      $cc->set($ck, json_encode($result));
    }
    return $result;
  }
};
