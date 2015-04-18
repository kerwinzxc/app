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
  public function exists($key)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->exists($key);
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
  public function setex($key, $expire, $v)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->setex($key, $expire, $v);
  }
  public function del($key)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->del($key);
  }
  public function incr($key)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->incr($key);
  }
  public function decr($key)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->decr($key);
  }

  //= list
  public function lsize($key)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->lsize($key);
  }
  public function lpush($key, $v)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->lpush($key, $v);
  }
  public function lpushx($key, $v)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->lpushx($key, $v);
  }
  public function lremove($key, $v, $n)
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->lremove($key, $v, $n);
  }
  public function lrange($key, $start, $end) // 闭区间
  {
    if ($this->connected === false) { if ($this->connect($key) === false) return false; }
    return $this->redis->lrange($key, $start, $end);
  }
};
