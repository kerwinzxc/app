<?php

class check
{
  static $can_upload_photos = array("image/jpg",
                                    "image/jpeg",
                                    "image/gif",
                                    "image/png");

  public static function is_phone_num($v)
  {
    return preg_match('/^1[34578]\d{9}$/', $v);
  }
  public static function is_coord($v)
  {
    if (!is_numeric($v) || strlen($v) > 10) {
      return false;
    }
    return true;
  }
  public static function is_user($v)
  {
    return preg_match('/^[\w]{3,20}$/', $v);
  }
  public static function is_passwd($v)
  {
    return preg_match('/^[\w~!@#$%^&*()\-_=+,.:;]{6,18}$/', $v);
  }
  public static function is_id_card($v)
  {
    if ((strlen($v) != 15 && strlen($v) != 18)
        || !preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $v)) {
      return false;
    }
    return true;
  }
  public static function is_name($v)
  {
    $len = strlen($v);
    if ($len > 18 || $len < 3) {
      return false;
    }
    return preg_match("/^[\w\x7f-\xff]+$/", $v);
  }
  public static function is_sex($v)
  { return ((int)$v == 1 || (int)$v == 0); }
  public static function is_0_or_1($v)
  { return ((int)$v == 1 || (int)$v == 0); }
  public static function is_date($v)
  {
    $dt = explode('-', $v);
    if (count($dt) == 3 && is_numeric($dt[0]) && is_numeric($dt[1]) && is_numeric($dt[2])) {
      return checkdate($dt[1], $dt[2], $dt[0]);
    }
    return false;
  }
  public static function is_doctor_classify($v)
  {
    $v = (int)$v;
    if ($v <= 0 || $v > 100) {
      return false;
    }
    return true;
  }
  public static function can_upload($type)
  {
    return in_array($type, check::$can_upload_photos);
  }
  public static function is_ke_shi($v)
  {
    return $v > 0;
  }
};
