<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_user_gz_ke_shi
{
  private static $tb_name  = 'user_gz_ke_shi';
  private static $all_cols = '*';

  public static function insert_some_one($user_id, $ke_shi_list)
  {
    if ($empty($ke_shi_list)) {
      return true;
    }
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "insert into "
      . self::$tb_name
      . "(user_id,ke_shi)"
      . "values";
    foreach ($ke_shi_list as $ke_shi) {
      $sql = $sql . "({$user_id},{$ke_shi})";
    }
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() > 0) {
      // for cache
      $cc = new cache();
      $ck = CK_USER_GZ_KE_SHI_LIST . $user_id;
      $cc->del($ck);
      return true;
    }
    return false;
  }
  public static function del_one($user_id, $ke_shi)
  {
    if (empty($user_id) || empty($ke_shi)) {
      return false;
    }
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "delete from "
      . self::$tb_name
      . " where user_id={$user_id} and ke_shi={$ke_shi} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_USER_GZ_KE_SHI_LIST . $user_id;
      $cc->del($ck);
    }
    return true;
  }

  public static function query_user_guan_zhu_num($user_id)
  {
    if (empty($user_id)) {
      return false;
    }
    // for cache
    $cc = new cache();
    $ck = CK_USER_GZ_KE_SHI_LIST . $user_id;
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
  // return false on error, return array on ok.
  public static function query_user_guan_zhu_list($user_id)
  {
    if (empty($user_id)) {
      return false;
    }
    // for cache
    $cc = new cache();
    $ck = CK_USER_GZ_KE_SHI_LIST . $user_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      return json_decode($result, true);
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select ke_shi from "
      . self::$tb_name
      . " where user_id={$user_id}";
    $result = $db->get_rows($sql);

    if ($result !== false) {
      $result = array_map(function ($r) { return (int)$r['ke_shi'];}, $result);
      // for cache
      $cc->set($ck, json_encode($result));
    }
    return $result;
  }
  public static function query_user_had_guan_zhu_or_not($user_id, $ke_shi)
  {
    if (empty($user_id) || empty($ke_shi)) {
      return true;
    }
    $ke_shi = (int)$ke_shi;
    // for cache
    $cc = new cache();
    $ck = CK_USER_GZ_KE_SHI_LIST . $user_id;
    $result = $cc->get($ck);
    if ($result !== false) {
      $result = json_decode($result, true);
      if (in_array($ke_shi, $result)) {
        return true;
      }
      return false;
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select 1 from "
      . self::$tb_name
      . " where user_id={$user_id} and ke_shi={$ke_shi}";
    return $db->get_one_row_col($sql, 0) == '1';
  }
};
