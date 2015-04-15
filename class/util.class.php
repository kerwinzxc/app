<?php

class util
{
  public static function generate_order_id()
  { return date('ymd') . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT); }

  public static function get_file_ext($path)
  {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    return $ext == '' ? 'dat' : $ext;
  }
  function post_data($url, $data, $timeout = 2)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
  }
  public static function escape($str)
  {
    return mysql_escape_string($str);
  }

  public static function array_get($key, $arr, $default_v)  
  {
    if (!array_key_exists($key, $arr)) {
      return $default_v;
    }
    return $arr[$key];
  }

};
