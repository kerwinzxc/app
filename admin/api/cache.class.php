<?php

class cache
{
  public static function get($key)
  {
    $redis = new Redis();
    $ret = $redis->pconnect('192.168.1.220', 6379, 1, NULL, 100);
    if ($ret === false)
      return false;
    return $redis->get($key);
  }
  public static function set($key, $v)
  {
    $redis = new Redis();
    $ret = $redis->pconnect('192.168.1.220', 6379, 1, NULL, 100);
    if ($ret === false)
      return false;
    return $redis->set($key, $v);
  }
  public static function del($key)
  {
    $redis = new Redis();
    $ret = $redis->pconnect('192.168.1.220', 6379, 1, NULL, 100);
    if ($ret === false)
      return false;
    return $redis->del($key);
  }
  public static function get_sid($sid)
  { return cache::get("sid:info=" . $sid); }
  public static function set_sid($sid, $v)
  { return cache::set("sid:info=" . $sid, $v); }
};
