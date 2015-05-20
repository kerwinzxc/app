<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_user
{
  private static $tb_name  = 'user';
  private static $all_cols = '*';

  public static function insert_new_one($phone_num, $passwd, $c_time)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "insert into "
      . self::$tb_name
      . "(phone_num,passwd,c_time)"
      . "value('$phone_num','$passwd',$c_time)";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      return $db->get_insert_id();
    }
    return false;
  }
  public static function set_profile($user_id, $nick_name, $name, $id_card)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $name = $db->escape($name);
    $nick_name = $db->escape($nick_name);
    $sql = "update "
      . self::$tb_name
      . " set "
      . "name='{$name}',id_card='{$id_card}',nick_name='{$nick_name}'"
      . " where id={$user_id} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }

    // for cache
    $cc = new cache();
    $ck = CK_USER_ID_2_USER . $user_id;
    $cc->del($ck);

    return true;
  }
  public static function set_icon_url($user_id, $icon_url)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "update "
      . self::$tb_name
      . " set "
      . "icon_url='{$icon_url}'"
      . " where id={$user_id} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }

    // for cache
    $cc = new cache();
    $ck = CK_USER_ID_2_USER . $user_id;
    $cc->del($ck);

    return true;
  }
  public static function set_default_patient($user_id, $patient_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "update "
      . self::$tb_name
      . " set "
      . "default_patient={$patient_id}"
      . " where id={$user_id} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }

    // for cache
    $cc = new cache();
    $ck = CK_USER_ID_2_USER . $user_id;
    $cc->del($ck);

    return true;
  }
  public static function update_passwd($user_id, $new_passwd)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "update "
      . self::$tb_name
      . " set "
      . "passwd='{$new_passwd}'"
      . " where id={$user_id} limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }

    // for cache
    $cc = new cache();
    $ck = CK_USER_ID_2_USER . $user_id;
    $cc->del($ck);

    return true;
  }

  // return false on error, return array on ok.
  public static function query_user_by_phone_num($phone_num)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " where phone_num='$phone_num' limit 1";
    return $db->get_row($sql);
  }
  // return false on error, return array on ok.
  public static function query_user_by_id($id)
  {
    // for cache
    $cc = new cache();
    $ck = CK_USER_ID_2_USER . $id;
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
  public static function query_user_id_card_exist_or_not($id_card)
  {
    if (empty($id_card)) { return true; }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select 1 from "
      . self::$tb_name
      . " where id_card='{$id_card}' limit 1";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) return false;
    return $ret == '1';
  }
  public static function query_user_nick_name_exist_or_not($nick_name)
  {
    if (empty($nick_name)) { return true; }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select 1 from "
      . self::$tb_name
      . " where nick_name='{$nick_name}' limit 1";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) return false;
    return $ret == '1';
  }
  public static function query_name_by_id($id, &$name, &$icon_url)
  {
    $user_info = self::query_user_by_id($id);
    if ($user_info === false) {
      return false;
    }
    $name = $user_info['nick_name'];
    $icon_url = $user_info['icon_url'];
    return true;
  }
};
