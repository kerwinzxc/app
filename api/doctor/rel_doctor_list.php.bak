<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['doctor_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $doctor_id = (int)$_GET['doctor_id'];
  if ($doctor_id <= 0) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
  if ($doctor_info === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  } elseif (empty($doctor_info)) {
    $ret_code = ERR_DOCTOR_NOT_EXIST;
    break;
  }

  $doctor_list = array();
  if ($doctor_info['classify'] == '2') { // expert
    $doctor_list = tb_doctor::query_slave_doctor_list($doctor_id);
  } else {
    $result = tb_doctor::query_doctor_by_id($doctor_info['master_id']);
    if (!empty($result)) {
      $doctor_list[] = $result;
    }
  }
  $doctor_detail_list = fn_doctor::build_doctor_detail_list_from_info_list($doctor_list);

  $ret_body['list'] = $doctor_detail_list;
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
