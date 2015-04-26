<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_POST['user'])
      || empty($_POST['passwd'])
      || empty($_POST['sms_code'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $phone_num = $_POST['user'];
  $passwd    = $_POST['passwd'];
  $sms_code  = $_POST['sms_code'];

  if (!check::is_phone_num($phone_num)
      || !check::is_passwd($passwd)
      || !check::is_sms_code($sms_code)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  /* for test
  if (sms::verify_reg_sms($phone_num, $sms_code)) {
    $ret_code = ERR_SMS_ERROR;
    break;
  }*/
  $user_info = tb_user::query_user_by_phone_num($phone_num);
  if ($user_info === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  if (!empty($user_info)) {
    $ret_code = ERR_PHONE_NUM_HAD_REG;
    break;
  }

  $passwd = md5($passwd);
  $new_user_id = tb_user::insert_new_one($phone_num, $passwd, time());
  if ($new_user_id === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }

  $sid = user_session::generate_sid(); 

  $s_info = array('user_id' => $new_user_id,
                  "default_patient" => 0);
  user_session::set_session($sid, json_encode($s_info));

  $ret_body['sid'] = $sid;

} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
