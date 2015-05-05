<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['sid'])
      || empty($_GET['nick_name'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_GET['sid'];
  $nick_name = $_GET['nick_name'];

  if (!user_session::is_sid($sid)
      || !check::is_name($nick_name)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  if (get_magic_quotes_gpc()) {
    $nick_name = stripslashes($nick_name);
  }

  $s_info = user_session::get_session($sid);
  if ($s_info === false) {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }

  $s_info = json_decode($s_info, true);
  if (empty($s_info)) {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }

  if (tb_user::query_user_nick_name_exist_or_not($nick_name)) {
    $ret_code = ERR_USER_NICK_NAME_EXIST;
    break;
  }
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
