<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_POST['sid'])
      || empty($_POST['patient_id'])
      || empty($_POST['sd_time'])
      || empty($_POST['hospital'])
      || empty($_POST['ke_shi'])
      || empty($_POST['doctor_name'])
      || empty($_POST['doctor_diagnosis'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_POST['sid'];
  $patient_id = (int)$_POST['patient_id'];
  $sd_time = strtotime($_POST['sd_time']);
  $hospital = $_POST['hospital'];
  $ke_shi = $_POST['ke_shi'];
  $doctor_name = $_POST['doctor_name'];
  $doctor_diagnosis = $_POST['doctor_diagnosis'];
  $photoes_1 = '';
  $photoes_2 = '';
  if (!user_session::is_sid($sid)
      || !check::is_name($doctor_name)
      || strlen($ke_shi) > 90
      || $sd_time === false
      || strlen($doctor_diagnosis) > 450) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $doctor_tell = '';
  if (isset($_POST['doctor_tell'])) {
    $doctor_tell = $_POST['doctor_tell'];
    if (strlen($doctor_tell) > 450) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
  }
  if (get_magic_quotes_gpc()) {
    $hospital = stripslashes($hospital);
    $ke_shi = stripslashes($ke_shi);
    $doctor_name = stripslashes($doctor_name);
    $doctor_tell = stripslashes($doctor_tell);
    $doctor_diagnosis = stripslashes($doctor_diagnosis);
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

  $new_emr_id = tb_patient_emr::insert_new_one($user_id,
                                               $patient_id,
                                               $sd_time,
                                               $hospital,
                                               $ke_shi,
                                               $doctor_name,
                                               $photoes_1,
                                               $photoes_2,
                                               $doctor_diagnosis,
                                               $doctor_tell);
  if ($new_emr_id === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $ret_body['emr_id'] = $new_emr_id;
} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
