<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;

$ret_code = 0;
$result = array();

do {
  if (empty($_POST['user'])
      || empty($_POST['passwd'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $phone_num = $_POST['user'];
  $passwd = $_POST['passwd'];

  if (!check::is_phone_num($phone_num)
      || !check::is_passwd($passwd)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $passwd = md5($passwd);
  $user_info = tb_user::query_user_by_phone_num($phone_num);
  if ($user_info === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  if (empty($user_info)) {
    $ret_code = ERR_USER_NOT_EXIST;
    break;
  } elseif ($passwd != $user_info['passwd']) {
    $ret_code = ERR_PASSWD_ERR;
    break;
  }

  $sid = user_session::generate_sid(); 

  $s_info = array('user_id' => $user_info['id'],
                  "default_patient" => 0);
  user_session::set_session($sid, json_encode($s_info));

  $ret_body['sid'] = $sid;

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
