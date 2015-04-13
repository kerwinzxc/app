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

};
