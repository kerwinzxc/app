<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('ONE_PAGE_ITEMS', 10);

$ret_code = 0;
$ret_body = array();

do {
  $total_num = 0;
  $page = 1;

  if (empty($_GET['disease_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $disease_id = (int)$_GET['disease_id'];
  if ($disease_id <= 0) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  if (!empty($_GET['p'])) {
    $page = (int)$_GET['p'];
  }

  $doctor_detail_list = array();
  $total_num = tb_disease_rel_doctor::query_doctor_total_num($disease_id);
  if ($total_num > 0
      && ($page - 1) * ONE_PAGE_ITEMS <= $total_num
      && $page >= 1) {
    $doctor_list = tb_disease_rel_doctor::query_doctor_limit($disease_id,
                                                             ($page - 1) * ONE_PAGE_ITEMS,
                                                             ONE_PAGE_ITEMS);
    if ($doctor_list === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }

    $doctor_list = array_map(function ($r) { return (int)$r['doctor_id'];}, $doctor_list);
    $doctor_detail_list = fn_doctor::build_doctor_detail_list_from_id_list($doctor_list);
  }
  $ret_body['list'] = $doctor_detail_list;
  $ret_body['total_num'] = $total_num;
  $ret_body['p'] = $page;

} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
