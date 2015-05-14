<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_POST['sid'])
      || empty($_POST['passwd'])
      || empty($_POST['new_passwd'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_POST['sid'];
  $passwd = $_POST['passwd'];
  $new_passwd = $_POST['new_passwd'];

  if (!user_session::is_sid($sid)
      || !check::is_passwd($passwd)
      || !check::is_passwd($new_passwd)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  if ($passwd == $new_passwd) {
    $ret_code = 0;
    break;
  }
  $passwd = md5($passwd);
  $new_passwd = md5($new_passwd);

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
  $user_id = $s_info['user_id'];

  $user_info = tb_user::query_user_by_id($user_id);
  if ($user_info === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  if (empty($user_info)) {
    $ret_code = ERR_USER_NOT_EXIST;
    break;
  } elseif ($passwd != $user_info['passwd']) {
    $ret_code = ERR_OLD_PASSWD_ERROR;
    break;
  }

  if (tb_user::update_passwd($user_id, $new_passwd) === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
