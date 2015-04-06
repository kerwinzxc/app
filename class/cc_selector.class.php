<?php

class cc_selector
{
  private static $chash;
  private static $cc_list = array('192.168.1.122:6379', '192.168.1.122:6380');

  public static function get_cache($key)
  {
    if (!isset(self::$chash)) {
      self::$chash = new chash($cc_list);
    }
    return $self::$chash->get($key);
  }
};
