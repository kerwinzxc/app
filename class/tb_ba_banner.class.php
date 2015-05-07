<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_ba_banner
{
  private static $tb_name  = 'ba_banner';
  private static $all_cols = '*';

  public static function insert_new_one($priority,
                                        $img_url,
                                        $target)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $target = $db->escape($target);
    $sql = "insert into "
      . self::$tb_name
      . "(priority,img_url,target)"
      . "value($priority,'$img_url','$target')";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_BA_BANNER_LIST;
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
    $ck = CK_BA_BANNER_LIST;
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
    $ck = CK_BA_BANNER_LIST;
    $cc->del($ck);

    return true;
  }

  public static function query_ba_banner_list()
  {
    // for cache
    $cc = new cache();
    $ck = CK_BA_BANNER_LIST;
    $result = $cc->get($ck);
    if ($result !== false) {
      return json_decode($result, true);
    }

    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " order by priority asc";
    $result = $db->get_rows($sql);

    // for cache
    if ($result !== false) {
      $cc->set($ck, json_encode($result));
    }
    return $result;
  }
};
