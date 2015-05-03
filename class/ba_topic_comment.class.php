<?php

require_once APP_ROOT . '/common/nosql_key_def.php';

class ba_topic_comment
{
  private static $nosql;

  public static function get_user_zan($user_id, $topic_id)
  {
    if (!isset(self::$nosql)) self::$nosql = new nosql();
    return self::$nosql->get(NK_USER_BA_TOPIC_ZAN . $topic_id . ":" . $);
  }
  public static function set_user_comment($user_id, $topic_id, $comment)
  {
    if (!isset(self::$nosql)) self::$nosql = new nosql();
    return self::$nosql->set(NK_USER_BA_TOPIC_COMMENT . $user_id . ":" . $topic_id, $comment);
  }
};
