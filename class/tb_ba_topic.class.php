<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class tb_ba_topic
{
  private static $tb_name  = 'ba_topic';
  private static $all_cols = '*';

  public static function insert_new_one($ba_id,
                                        $user_id,
                                        $topic,
                                        $content,
                                        $c_time)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $topic = $db->escape($topic);
    $content = $db->escape($content);
    $sql = "insert into "
      . self::$tb_name
      . "(ba_id,user_id,topic,content,c_time)"
      . "value($ba_id,$user_id,'$topic','$content',$c_time)";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      return $db->get_insert_id();
    }
    return false;
  }
  public static function del_one($topic_id)
  {
    if (empty($topic_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "delete from "
      . self::$tb_name
      . " where id=$topic_id limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }
    return $db->affected_rows() == 1 ? 1 : 0;
  }
  public static function incr_zan_counter($topic_id)
  {
    if (empty($topic_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "update "
      . self::$tb_name
      . " set zan=zan+1 where id=$topic_id limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_TOPIC_ID_2_TOPIC . $topic_id;
      $cc->del($ck);
    }
    return true;
  }
  public static function decr_zan_counter($topic_id)
  {
    if (empty($topic_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "update "
      . self::$tb_name
      . " set zan=zan-1 where id=$topic_id and zan > 0 limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_TOPIC_ID_2_TOPIC . $topic_id;
      $cc->del($ck);
    }
    return true;
  }
  public static function incr_comment_counter($topic_id)
  {
    if (empty($topic_id)) { return false; }

    $db = new sql(db_selector::get_db(db_selector::$db_w));
    $sql = "update "
      . self::$tb_name
      . " set coment=coment+1 where id=$topic_id limit 1";
    if ($db->execute($sql) === false) {
      return false;
    }
    if ($db->affected_rows() == 1) {
      // for cache
      $cc = new cache();
      $ck = CK_TOPIC_ID_2_TOPIC . $topic_id;
      $cc->del($ck);
    }
    return true;
  }

  public static function query_topic_total_num($ba_id)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select count(*) from "
      . self::$tb_name
      . " where ba_id=$ba_id";
    $ret = $db->get_one_row_col($sql, 0);
    if ($ret === false) {
      return false;
    }
    return (int)$ret;
  }
  // return false on error, return array on ok.
  public static function query_topic_by_id($id)
  {
    if (empty($id)) { return false; }

    // for cache
    $cc = new cache();
    $ck = CK_TOPIC_ID_2_TOPIC . $id;
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
  public static function query_topic_limit($ba_id, $start, $offset)
  {
    $db = new sql(db_selector::get_db(db_selector::$db_r));
    $sql = "select id,ba_id,user_id,topic,zan,coment,c_time"
      . " from "
      . self::$tb_name
      . " where ba_id=$ba_id order by zan desc limit {$start},{$offset}";
    return $db->get_rows($sql);
  }
};
