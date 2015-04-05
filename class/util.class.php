<?php

class util
{
  public static function generate_order_id()
  { return date('ymd') . str_pad(mt_rand(1, 10000000), 7, STR_PAD_LEFT); }

  public static function generate_sid()
  { return md5(uniqid(mt_rand(), true) . uniqid(mt_rand(), true)); }
};
