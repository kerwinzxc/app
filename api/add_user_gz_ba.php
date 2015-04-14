<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('MAX_GZ_BA_NUMBER', 50);

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['sid'])
      || empty($_GET['ba_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_GET['sid'];
  $ba_id = (int)$_GET['ba_id'];
  if (!user_session::is_sid($sid)
      || $ba_id <= 0) {
    $ret_code = ERR_PARAM_INVALID;
    break;
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
  $user_id = $s_info['user_id'];

  $num = tb_user_gz_ba::query_user_guan_zhu_num($user_id);
  if ($num === false
      || $num >= MAX_GZ_BA_NUMBER) {
    $ret_code = ERR_USER_GZ_BA_LIMIT;
    break;
  }
  if (tb_user_gz_ba::query_user_had_guan_zhu_or_not($user_id, $ba_id)) {
    $ret_code = ERR_USER_GZ_BA_EXIST;
    break;
  }

  if (tb_user_gz_ba::insert_new_one($user_id, $ba_id) === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $ret_body['ba_id'] = $ba_id;

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
