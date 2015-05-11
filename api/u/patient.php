<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['do'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  // check params
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

  $act = $_GET['do'];
  if ($act == 'get') { // get
    $patient_list = tb_user_patient::query_user_patient_list($user_id);
    if ($patient_list === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
    $real_patient_list = array();
    foreach ($patient_list as $p) {
      $real_p = array();
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
      $real_patient_list[] = $real_p;
    }
    $ret_body['list'] = $real_patient_list;
  } else { // other need params
    if (empty($_GET['patient_id'])) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    $patient_id = (int)$_GET['patient_id'];
    if ($patient_id <= 0) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    if ($act == 'del') { // del
      if (tb_user_patient::del_one($user_id, $patient_id) === false) {
        $ret_code = ERR_INNER_ERROR;
        break;
      }
      if ((int)$s_info['default_patient'] == $patient_id) {
        if (tb_user::set_default_patient($user_id, 0) !== false) {
          $s_info['default_patient'] = 0;
          user_session::set_session($sid, json_encode($s_info));
        }
      }
      $ret_body['patient_id'] = $patient_id;
    } elseif ($act == 'set_default') { // set default
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
    } elseif ($act == 'get_default') { // get default
      $patient_list = tb_user_patient::query_user_patient_list($user_id);
      if ($patient_list === false) {
        $ret_code = ERR_DB_ERROR;
        break;
      }
      $def_patient_id = 0;
      $def_patient_name = '';
      foreach ($patient_list as $p) {
        if ((int)$p['id'] === (int)$s_info['default_patient']) {
          $def_patient_id = (int)$p['id'];
          $def_patient_name = $p['name'];
          break;
        }
      }
      $ret_body['patient_id'] = $def_patient_id;
      $ret_body['patient_name'] = $def_patient_name;
    } else {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
  } // // end of `if ($act'
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
