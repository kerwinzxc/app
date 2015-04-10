<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$result = array();

do {
  if (empty($_GET['sid'])
    || empty($_GET['doctor_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_GET['sid'];
  $doctor_id = (int)$_GET['doctor_id'];
  if (!user_session::is_sid($sid)
    || $doctor_id <= 0) {
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

  $num = tb_user_guan_zhu::query_user_guan_zhu_num($user_id);
  if ($num === false || $num >= 100) {
    $ret_code = ERR_USER_GUAN_ZHU_LIMIT;
    break;
  }

  if (tb_user_guan_zhu::query_user_guan_zhu_or_not($user_id, $doctor_id)) {
    $ret_code = ERR_USER_GUAN_ZHU_EXIST;
    break;
  }

  if (tb_user_guan_zhu::insert_new_one($user_id, $doctor_id) === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $ret_body['doctor_id'] = $doctor_id;

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
