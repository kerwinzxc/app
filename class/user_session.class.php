<?php

require_once ROOT . '/common/cc_key_def.php';

class user_session
{
  private static $nosql;

  /**
   * { 
   *   "user_id":1234,
   *
   * }
   */
  public static function generate_sid()
  { return md5(uniqid(mt_rand(), true) . uniqid(mt_rand(), true)); }
  public static function is_sid($v)
  { return strlen($v) == 32; }

  public static function get_session($sid)
  {
    if (!isset(self::$nosql))
      self::$nosql = new nosql();
    return self::$nosql->get(CK_USER_SID . $sid);
  }
  public static function set_session($sid, $v)
  {
    if (!isset(self::$nosql))
      self::$nosql = new nosql();
    return self::$nosql->set(CK_USER_SID . $sid, $v);
  }
};
