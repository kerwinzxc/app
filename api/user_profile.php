<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$result = array();

do {
  $sid = $_GET['sid'];

  if (!session::is_sid($sid)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $s_info = session::get_session($sid);
  if ($s_info === false) {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }

  $s_info = json_decode($s_info);
  if ($s_info == false) {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }
  $uid = $s_info->uid;
  $user_info = tb_user::query_user_by_uid($uid);
  if ($user_info === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  if (empty($user_info)) {
    $ret_code = ERR_USER_NOT_EXIST;
    break;
  }
  $ret_body['name'] = $user_info['name'];
  $ret_body['sex'] = $user_info['sex'];
  $ret_body['birth_year'] = $user_info['birth_year'];

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
