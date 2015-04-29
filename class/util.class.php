<?php

class util
{
  public static function generate_order_id()
  { return date('ymd') . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT); }

  public static function post_data($url, $data, $timeout = 1)
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($curl);
    curl_close($curl);
    return $ret;
  }
  public static function set_image_size($path, $width, $height)
  {
    $size = getimagesize($path);
    if ($size[2] == 1) {
      $im_in = imagecreatefromgif($path);   
    } else if ($size[2] == 2) {
      $im_in = imagecreatefromjpeg($path);   
    } else if ($size[2] == 3) {
      $im_in = imagecreatefrompng($path);  
    }

    $im_out = imagecreatetruecolor($width, $height);
    imagecopyresampled($im_out,$im_in,0,0,0,0,$width,$height,$size[0],$size[1]);
    imagejpeg($im_out, $path);
    chmod($path, 0644);
    imagedestroy($im_in);
    imagedestroy($im_out);
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
