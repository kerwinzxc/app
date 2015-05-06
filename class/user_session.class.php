<?php

require_once APP_ROOT . '/common/nosql_key_def.php';

class user_session
{
  private static $nosql;

  /**
   * { 
   *   "user_id":1234,
   * }
   */
  public static function generate_sid()
  { return md5(uniqid(mt_rand(), true) . uniqid(mt_rand(), true)); }
  public static function is_sid($v)
  { return strlen($v) == 32; }

  public static function get_session($sid)
  {
    if (!isset(self::$nosql)) self::$nosql = new nosql();
    return self::$nosql->get(NK_USER_SID . $sid);
  }
  public static function set_session($sid, $v)
  {
    if (!isset(self::$nosql)) self::$nosql = new nosql();
    return self::$nosql->set(NK_USER_SID . $sid, $v);
  }
  public static function del_session($sid)
  {
    if (!isset(self::$nosql)) self::$nosql = new nosql();
    return self::$nosql->del(NK_USER_SID . $sid);
  }
};
