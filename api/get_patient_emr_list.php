<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['sid'])
      || empty($_GET['patient_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $sid = $_GET['sid'];
  $patient_id = $_GET['patient_id'];
  if ($patient_id <= 0) {
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

  $total_num = tb_patient_emr::query_patient_emrs_num($patient_id);
  if ($total_num > 0) {
    $emr_list = tb_patient_emr::query_patient_emr_list($patient_id);
    if ($emr_list === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
    $ret_body['list'] = fn_patient_emr::build_emr_detail_list($emr_list);
    $ret_body['total_num'] = $total_num;
  } else {
    $ret_body['list'] = array();
    $ret_body['total_num'] = 0;
  }

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
