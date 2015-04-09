<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$result = array();

do {
  if (empty($_GET['sid'])) {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }
  $sid = $_GET['sid'];

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

  $pl = tb_user_patient::query_user_patient_list($user_id);
  if ($pl === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $ret_body['list'] = $pl;

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
