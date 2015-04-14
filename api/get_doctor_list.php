<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  $total_num = 0;
  $doctor_list = array();
  if (empty($_GET['sid'])) { // guest
    $total_num = fn_doctor::query_expert_total_num();
    $doctor_list = fn_doctor::query_expert_order_by_limit(0, 10);
    if ($doctor_list === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
  } else {
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

    $doctor_list = tb_doctor::query_doctor_limit(0,
        '', // where
        'order by id desc',
        10);
    if ($doctor_list === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
  } // end of `if'

  $dl = array_map(function ($r) { return $r['id'];}, $doctor_list);
  $ret_body['list'] = fn_doctor::build_doctor_detail_list($dl);

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
