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

  $info = tb_doctor_introduction::query_introduction_by_doctor_id($doctor_id);
  if ($info === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }

  $ret_body['content'] = empty($info) ? '' : $info['content'];
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
