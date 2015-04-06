<?php

class cache
{
  private static $conn_timeout = 0.6; // float second

  private $redis;
  private $connected = false;

  public function __construct()
  {
    $this->redis = new Redis();
  }
  private function connect($key)
  {
    if (self::$connected === false) {
      $server = cc_selector::get_cache($key);
      if (empty($server)) {
        return false;
      }
      $server = explode(":", $server);
      $ret = self::$redis->pconnect($server[0], (int)$server[1], self::$conn_timeout);
      if ($ret === false) {
        return false;
      }
      $this->connected = true;
    }
    return true;
  }

  public function get($key)
  {
    if ($this->connected === false) {
      if ($this->connect($key) === false)
        return false;
    }
    return $redis->get($key);
  }
  public function set($key, $v)
  {
    if ($this->connected === false) {
      if ($this->connect($key) === false)
        return false;
    }
    return $redis->set($key, $v);
  }
  public static function del($key)
  {
    if ($this->connected === false) {
      if ($this->connect($key) === false)
        return false;
    }
    return $redis->del($key);
  }
};
