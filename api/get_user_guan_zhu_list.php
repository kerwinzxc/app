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

  $gl = tb_user_guan_zhu::query_user_guan_zhu_list($user_id);
  if ($gl === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $gz_list_info = array();
  foreach ($gl as $item) {
    $doctor_info = tb_doctor::query_doctor_by_id($item['doctor_id']);
    if (!empty($doctor_info)) {
      $gz_list_info[] = array('doctor_id' => $item['doctor_id'],
                              'name' => $doctor_info['name'],
                              'sex' => $doctor_info['sex'],
                             );
    }
  }
  $ret_body['list'] = $gz_list_info;

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
