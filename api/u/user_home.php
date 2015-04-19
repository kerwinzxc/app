<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

function get_default_patient_name($user_id, $default_patient)
{
  $pl = tb_user_patient::query_user_patient_list($user_id);
  if ($pl !== false) {
    foreach ($pl as $p) {
      if ((int)$p['id'] === $default_patient) {
        return $p['name'];
      }
    }
  }
  return '';
}

do {
  if (empty($_GET['sid'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_GET['sid'];

  if (!user_session::is_sid($sid)) {
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

  $user_info = tb_user::query_user_by_id($user_id);
  if ($user_info === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  if (empty($user_info)) {
    $ret_code = ERR_USER_NOT_EXIST;
    break;
  }
  $ret_body['name'] = $user_info['name'];
  $ret_body['icon_url'] = $user_info['icon_url'];
  $default_patient = (int)$s_info['default_patient'];
  $ret_body['default_patient'] = $default_patient;
  if ($default_patient !== 0) {
    $ret_body['default_patient_name'] = get_default_patient_name($user_id,
                                                                 $default_patient);
  } else {
    $ret_body['default_patient_name'] = '';
  }

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
