<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_ba_topic_comment
{
  private static $tb_name  = 'ba_topic_comment';
  private static $all_cols = '*';

  public static function insert_new_one($topic_id,
                                        $user_id,
                                        $topic_author_id,
                                        $content,
                                        $c_time)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $content = $db->escape($content);
    $sql = "insert into "
      . self::$tb_name
      . "(topic_id,user_id,topic_author_id,content,c_time)"
      . "value($topic_id,$user_id,$topic_author_id,'$content',$c_time)";
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
    if (empty($id)) {
      return false;
    }
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "delete from "
      . self::$tb_name
      . " where id=$id limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }
    return $db->affected_rows() == 1 ? 1 : 0;
  }

  // return false on error, return array on ok.
  public static function query_topic_comment_by_id($id)
  {
    if (empty($id)) {
      return false;
    }
    // for cache
    $cc = new cache();
    $ck = CK_REPLY_ID_2_REPLY . $id;
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
  public static function query_topic_comment_total_num($topic_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*) from "
      . self::$tb_name
      . " where topic_id={$topic_id}";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) {
      return false;
    }
    return (int)$ret;
  }
  public static function query_topic_comment_limit($topic_id, $start, $offset)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select "
      . self::$all_cols
      . " from "
      . self::$tb_name
      . " where topic_id=$topic_id order by id asc limit {$start},{$offset}";
    return $db->get_rows($sql);
  }
};
