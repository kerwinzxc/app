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

  $default_content = '<center><p style="margin-top:80px">暂无简介</p></center>';
  $ret_body['content'] = empty($info) ? $default_content : $info['content'];
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
