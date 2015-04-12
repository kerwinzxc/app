<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$result = array();

do {
  if (empty($_GET['sid'])
      || empty($_GET['patient_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_GET['sid'];
  $patient_id = (int)$_GET['patient_id'];
  if (!user_session::is_sid($sid)
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
  if ((int)$s_info['default_patient'] != $patient_id) {
    $pl = tb_user_patient::query_user_patient_list($user_id);
    $found = false;
    foreach ($pl as $item) {
      if ((int)$item['id'] === (int)$patient_id) {
        $found = true;
        break;
      }
    }
    if ($found !== true) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    // update session info
    if (tb_user::set_default_patient($user_id, $patient_id) !== false) {
      $s_info['default_patient'] = $patient_id;
      user_session::set_session($sid, json_encode($s_info));
    }
  }
  $ret_body['default_patient'] = $patient_id;

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
