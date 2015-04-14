<?php

class cc_selector
{
  private static $chash;

  public static function get_cache($key)
  {
    if (!isset(self::$chash)) {
      $js = file_get_contents(APP_ROOT . "/conf/redis.json");
      if ($js === false) {
        ilog::fatal("open redis config failed!");
        return false;
      }
      $js = json_decode($js, true);
      if ($js === false || !isset($js['list'])) {
        ilog::fatal("redis config format error!");
        return false;
      }
      self::$chash = new chash($js['list']);
    }
    return self::$chash->get($key);
  }
};
