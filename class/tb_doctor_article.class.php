<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_doctor_article
{
  private static $tb_name  = 'doctor_article';
  private static $all_cols = '*';

  public static function insert_new_one($doctor_id,
                                        $icon_url,
                                        $article_type,
                                        $topic,
                                        $content,
                                        $c_time)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $topic = $db->escape($topic);
    $content = $db->escape($content);
    $sql = "insert into "
      . self::$tb_name
      . "(doctor_id,icon_url,article_type,topic,content,c_time)"
      . "value($doctor_id,'$icon_url',$article_type,'$topic','$content',$c_time)";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      return $db->get_insert_id();
    }
    return false;
  }
  public static function update($article_id, $doctor_id, $update_info)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "update "
      . self::$tb_name
      . " set " . $db->get_set($update_info)
      . " where id={$article_id} and doctor_id=$doctor_id limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }

    // for cache
    $cc = new cache();
    $ck = CK_DOCTOR_ARTICLE_ID_TO_INFO . $article_id;
    $cc->del($ck);

    return true;
  }

  // return false on error, return array on ok.
  public static function query_article_by_id($id)
  {
    if (empty($id)) { return false; }

    // for cache
    $cc = new cache();
    $ck = CK_DOCTOR_ARTICLE_ID_TO_INFO . $id;
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
  // return false on error, return array on ok.
  public static function query_article_by_doctor_id($doctor_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " where doctor_id=$doctor_id";
    return $db->get_rows($sql);
  }
  public static function query_article_total_num($where)
  {
    if (!empty($where)) {
      $where = " where $where";
    }
    
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*) from "
      . self::$tb_name
      . " {$where}";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) {
      return false;
    }
    return (int)$ret;
  }
  public static function query_article_limit($where,
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
