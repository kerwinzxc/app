<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_POST['sid'])
      || empty($_POST['doctor_id'])
      || empty($_POST['patient_id'])
      || empty($_POST['expected_time_b'])
      || empty($_POST['expected_time_e'])
      || empty($_POST['disease_desc'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_POST['sid'];
  $doctor_id = (int)$_POST['doctor_id'];
  $patient_id = (int)$_POST['patient_id'];
  $expected_time_b = strtotime($_POST['expected_time_b']);
  $expected_time_e = strtotime($_POST['expected_time_e']);
  $disease_desc = $_POST['disease_desc'];
  $photoe_1 = '';
  $photoe_2 = '';
  $photoe_3 = '';
  if (!user_session::is_sid($sid)
      || $doctor_id <= 0
      || $patient_id <= 0
      || $expected_time_b === false
      || $expected_time_e === false
      || strlen($disease_desc) > 450) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  if (get_magic_quotes_gpc()) {
    $disease_desc = stripslashes($disease_desc);
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

  $patient_list = tb_user_patient::query_user_patient_list($user_id);
  if ($patient_list === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $patient_info = array();
  foreach ($patient_list as $p) {
    if ((int)$p['id'] === (int)$patient_id) {
      $patient_info = $p;
      break;
    }
  }
  if (empty($patient_info)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
  if (empty($doctor_info)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $emr_url_set = array();
  $photoes = array('photo0', 'photo1', 'photo2');
  foreach ($photoes as $photo) {
    $path = "image/order/ol/" . date("Ymd");
    if (!empty($_FILES[$photo]['name'])) {
      $up = new upload($_FILES[$photo],
                       IMG_ROOT . "/" . $path,
                       2*1024*1024,
                       array('.jpg', '.jpeg', '.png')
                      );
      if ($up->just_do_it() === false) {
        $ret_code = ERR_UPLOAD_EMR_PHOTO_FAILED;
        ilog::error($up->error());
        break;
      }
      $emr_url_set[] = IMG_BASE_URL . $path . "/" . $up->filename();
    }
  }

  $new_order_id = tb_ol_ask_order::insert_new_one($user_id,
                                                  $doctor_id,
                                                  $patient_info['name'],
                                                  $patient_info['sex'],
                                                  $patient_info['id_card'],
                                                  $patient_info['phone_num'],
                                                  $disease_desc,
                                                  $expected_time_b,
                                                  $expected_time_e,
                                                  empty($emr_url_set) ? '' : implode(';', $emr_url_set),
                                                  time());
  if ($new_order_id === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
