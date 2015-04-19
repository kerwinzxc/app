<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['phone_num'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $phone_num = $_GET['phone_num'];
  if (!check::is_phone_num($phone_num)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  if (sms::check_recent_reg($phone_num, 45)) {
    $ret_code = ERR_REG_SMS_TIME_LIMIT;
    break;
  }
  if (sms::check_today_reg_limit($phone_num)) {
    $ret_code = ERR_REG_SMS_TODAY_LIMIT;
    break;
  }
  sms::update_recent_reg($phone_num, $code);

  $user_info = tb_user::query_user_by_phone_num($phone_num);
  if ($user_info === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  if (!empty($user_info)) {
    $ret_code = ERR_USER_EXIST;
    break;
  }

  if (sms::send_reg_sms_code($phone_num)) {
    sms::save_reg_sms_code($phone_num, $code);
  } else {
    $ret_code = ERR_REG_SMS_FAILED;
    break;
  }

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
