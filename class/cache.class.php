<?php

class cache
{
  private static $conn_timeout = 0.6; // float second

  private $connected = false;
  private $redis;

  public function __construct()
  {
    $this->redis = new Redis();
  }
  private function connect($key)
  {
    if ($this->connected === false) {
      $server = cc_selector::get_cache($key);
      if (empty($server)) {
        return false;
      }
      $server = explode(":", $server);
      $ret = $this->redis->pconnect($server[0], (int)$server[1], self::$conn_timeout);
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
    return $this->redis->get($key);
  }
  public function set($key, $v)
  {
    if ($this->connected === false) {
      if ($this->connect($key) === false)
        return false;
    }
    return $this->redis->set($key, $v);
  }
  public function setex($key, $v, $t)
  {
    if ($this->connected === false) {
      if ($this->connect($key) === false)
        return false;
    }
    return $this->redis->setex($key, $t, $v);
  }
  public function del($key)
  {
    if ($this->connected === false) {
      if ($this->connect($key) === false)
        return false;
    }
    return $this->redis->del($key);
  }
};
