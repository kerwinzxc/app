<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['ba_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $ba_id = (int)$_GET['ba_id'];
  if ($ba_id <= 0) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $result = tb_ba_rel_doctor::query_ba_rel_doctor_list($ba_id);
  if ($result === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $result = array_map(function ($r) { return (int)$r['doctor_id'];}, $result);
  $doctor_detail_list = fn_doctor::build_doctor_detail_list_from_id_list($result);

  $ret_body['list'] = $doctor_detail_list;
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
