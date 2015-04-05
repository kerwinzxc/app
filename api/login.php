<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

$ret_code = 0;
$result = array();

$phone_num = $_POST['user'];
$passwd = $_POST['passwd'];

do {
  if (!check::is_phone_num($phone_num) || !check::is_passwd($passwd)) {
    $ret_code = ERR_USER_PASSWD_ERR;
    break;
  } else {
    $passwd = md5($passwd);
    // TODO use redis;
    $user_info = tb_user::query_user_by_phone_num($phone_num);
    if ($user_info === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
    if (empty($user_info)
        || $passwd != $user_info['passwd'])
    {
      $ret_code = ERR_USER_PASSWD_ERR;
      break;
    }

    $sid = util::generate_sid(); 

    /*
    $sid_val = array('last_opt_time' => time(),
                     'uid' => $user_info['uid'],
                     'phone_num' => $user_info['phone_num'],
                     'lng' => '',
                     'lat' => '',
                    );
    if (cache::set($sid, json_encode($sid_val)) !== true)
    {
      $ret_code = ERR_CACHE_CONNECT_FAIL;
      break;
    }*/
    $ret_body['sid'] = $sid;
  }
} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
