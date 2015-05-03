<?php

class nosql
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
      $server = "192.168.0.220:6381";
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
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->get($key);
  }
  public function set($key, $v)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->set($key, $v);
  }
  public static function del($key)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->del($key);
  }
  public static function incr($key)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->incr($key);
  }
  public static function decr($key)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->decr($key);
  }
};
