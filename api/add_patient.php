<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$result = array();

do {
  if (empty($_GET['sid'])
    || empty($_GET['name'])
    || !isset($_GET['sex'])
    || empty($_GET['phone_num'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_GET['sid'];
  $sex = $_GET['sex'];
  $name = $_GET['name'];
  $phone_num = $_GET['phone_num'];
  if (!user_session::is_sid($sid)
    || !check::is_phone_num($phone_num)
    || !check::is_sex($sex)
    || !check::is_name($name)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  if (get_magic_quotes_gpc()) {
    $name = stripslashes($name);
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

  $num = tb_user_patient::query_user_patients_num($user_id);
  if ($num === false || $num >= 3) {
    $ret_code = ERR_USER_PATIENTS_LIMIT;
    break;
  }

  $new_patient_id = tb_user_patient::insert_new_one($user_id,
    $phone_num,
    $name,
    $sex);
  if ($new_patient_id === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $ret_body['sex'] = $sex;
  $ret_body['name'] = $name;
  $ret_body['phone_num'] = $phone_num;

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
