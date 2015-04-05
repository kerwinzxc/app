<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  $phone_num = $_GET['user'];
  $passwd    = $_GET['passwd'];

  if (!check::is_phone_num($phone_num) || !check::is_passwd($passwd)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $passwd = md5($passwd);
  $user_info = tb_user::query_user_by_phone_num($phone_num);
  if ($user_info === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  if (!empty($user_info)) {
    $ret_code = ERR_USER_EXIST;
    break;
  }

  $new_user_id = tb_user_id_pool::get_new_user_id();
  if ($new_user_id === false
      || (tb_user::insert_new_one($new_user_id,
          $phone_num,
          $passwd,
          time()) === false)) {
    $ret_code = ERR_DB_ERROR;
    break;
  }

  $sid = util::generate_sid(); 

  $ret_body['sid'] = $sid;

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
