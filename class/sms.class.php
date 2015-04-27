<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class sms
{
  public static function verify_code($length = 4)
  {
    if ($length < 3 || $length > 8) {
      $length = 6;
    }
    return mt_rand(pow(10, $length - 1), pow(10, $length) - 1);
  }
  public static function xml_to_array($xml)
  {
    $arr = array();
    $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    if (preg_match_all($reg, $xml, $matches)) {
      $count = count($matches[0]);
      for ($i = 0; $i < $count; $i++) {
        $subxml = $matches[2][$i];
        $key = $matches[1][$i];
        if (preg_match($reg, $subxml)) {
          $arr[$key] = self::xml_to_array($subxml);
        } else {
          $arr[$key] = $subxml;
        }
      }
    }
    return $arr;
  }
  public static function check_recent_reg($phone_num, $ltime = 45)
  {
    $cc = new cache();
    $ck = CK_PHONE_NUM_RECENT_REG_SMS_CODE . $phone_num;
    $cc_ret = $cc->get($ck);
    if ($cc_ret !== false) {
      if (time() - (int)$cc_ret < $ltime) {
        return true;
      }
    }
    return false;
  }
  public static function update_recent_reg($phone_num)
  {
    $cc = new cache();
    $ck = CK_PHONE_NUM_RECENT_REG_SMS_CODE . $phone_num;
    $cc_v = (string)time();
    $cc->set($ck, $cc_v);
  }
  public static function check_today_reg_limit($phone_num, $limit = 5)
  {
    $cc = new cache();
    $ck = CK_PHONE_NUM_TODAY_REG_SMS_CODE . $phone_num . ':' . date("Y-m-d");
    $cc_ret = $cc->incr($ck);
    if ($cc_ret !== false) {
      if ((int)$cc_ret > $limit) {
        return true;
      }
    }
    return false;
  }
  public static function save_reg_sms_code($phone_num, $code, $expire = 120)
  {
    $cc = new cache();
    $ck = CK_PHONE_NUM_2_REG_SMS_CODE . $phone_num;
    return $cc->setex($ck, $expire, "$code");
  }
  public static function verify_reg_sms($phone_num, $code)
  {
    $cc = new cache();
    $ck = CK_PHONE_NUM_2_REG_SMS_CODE . $phone_num;
    $ret = $cc->get($ck);
    if ($ret === false) {
      return false;
    }
    return $ret == $code;
  }
  public static function send_reg_sms_code($phone_num, $code)
  {
    $data = array('account' => 'cf_shaovi',
                  'password' => 'zhongwei',
                  'mobile' => $phone_num,
                  'content' => "您的验证码是：【{$code}】。请不要把验证码泄露给其他人。");
    $post_result = util::post_data('http://106.ihuyi.cn/webservice/sms.php?method=Submit', $data, 1);
    if (!empty($post_result)) {
      $post_result = self::xml_to_array($post_result);
      if ($post_result['SubmitResult']['code'] == 2) {
        return true;
      }
    }
    return false;
  }
};
