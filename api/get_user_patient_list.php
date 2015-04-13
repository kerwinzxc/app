<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$result = array();

do {
  if (empty($_GET['sid'])) {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }
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

  $pl = tb_user_patient::query_user_patient_list($user_id);
  if ($pl === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $real_pl = array();
  foreach ($pl as $p) {
    $real_p['patient_id'] = (int)$p['id'];
    $real_p['name'] = $p['name'];
    $real_p['sex'] = (int)$p['sex'];
    $real_p['id_card'] = $p['id_card'];
    $real_p['phone_num'] = $p['phone_num'];
    $real_p['birthday'] = $p['birthday'];
    $real_p['is_default'] = 0;
    if ((int)$p['id'] === (int)$s_info['default_patient']) {
      $real_p['is_default'] = 1;
    }
    $real_pl[] = $real_p;
  }
  $ret_body['list'] = $real_pl;

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
