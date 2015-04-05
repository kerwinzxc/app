<?php

class check
{
  public static function is_phone_num($v)
  {
    if (!preg_match('/^1[34578]\d{9}$/', $v))
      return false;
    return true;
  }
  public static function is_coord($v)
  {
    if (!is_numeric($v) || strlen($v) > 10)
      return false;
    return true;
  }
  public static function is_user($v)
  {
    if (!preg_match('/^[\w]{3,20}$/', $v))
      return false;
    return true;
  }
  public static function is_passwd($v)
  {
    if (!preg_match('/^[\w~!@#$%^&*()\-_=+,.:;]{6,18}$/', $v))
      return false;
    return true;
  }
};