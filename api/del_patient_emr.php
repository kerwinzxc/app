<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['sid'])
      || empty($_GET['emr_id'])
      || empty($_GET['patient_id'])
      ) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_GET['sid'];
  $emr_id = (int)$_GET['emr_id'];
  $patient_id = (int)$_GET['patient_id'];
  if (!user_session::is_sid($sid)
      || $emr_id <= 0
      || $patient_id <= 0) {
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

  // del
  $ret = tb_patient_emr::del_one($emr_id, $user_id, $patient_id);
  if ($ret === false) {
    $ret_code = ERR_INNER_ERROR;
    break;
  } elseif ($ret === 1) {
    $ret_body['patient_id'] = $patient_id;
    $ret_body['emr_id'] = $emr_id;
  } else {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
