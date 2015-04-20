<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('ONE_PAGE_ITEMS', 10);
define('MAX_EMR_PER_PATIENT_NUMBER', 100);

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['do'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  // check params
  if (empty($_GET['sid']) ) {
    $ret_code = ERR_PARAM_INVALID;
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
  if ($act == 'get_list') {
    if (empty($_GET['patient_id'])) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    $patient_id = $_GET['patient_id'];
    if ($patient_id <= 0) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }

    $total_num = tb_patient_emr::query_patient_emrs_num($patient_id);
    $emr_list = array();
    $page = 1;
    if ($total_num > 0) {
      if (!empty($_GET['p'])) { $page = (int)$_GET['p']; }
      if (($page - 1) * ONE_PAGE_ITEMS > $total_num) {
        $page = (int)($total_num / ONE_PAGE_ITEMS) + 1;
      }
      if ($page < 1) { $page = 1; }
      $emr_list = tb_patient_emr::query_patient_emr_limit($patient_id,
                                                          ($page - 1) * ONE_PAGE_ITEMS,
                                                          ONE_PAGE_ITEMS);
      if ($emr_list === false) {
        $ret_code = ERR_DB_ERROR;
        break;
      }
      $emr_list = fn_patient_emr::build_emr_detail_list($emr_list);
    } // end of `if ($total_num'
    $ret_body['list'] = $emr_list;
    $ret_body['total_num'] = $total_num;
    $ret_body['p'] = $page;
  } else { // other need emr_id
    if (empty($_GET['emr_id'])) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    $emr_id = $_GET['emr_id'];
    if ($emr_id <= 0) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    if ($act == 'detail') { // get one detail
      $emr = tb_patient_emr::query_emr_by_id($emr_id);
      if ($emr === false) {
        $ret_code = ERR_DB_ERROR;
        break;
      } elseif (empty($emr)) {
        $ret_code = ERR_PATIENT_EMR_NOT_EXIST;
        break;
      } elseif ((int)$emr['user_id'] != (int)$user_id) {
        $ret_code = ERR_PARAM_INVALID;
        break;
      }
      $ret_body['emr_id'] = $emr['id'];
      $ret_body['sd_time'] = $emr['sd_time'];
      // TODO
    } elseif ($act == 'del') { // del
      $ret = tb_patient_emr::del_one($emr_id, $user_id);
      if ($ret === false) {
        $ret_code = ERR_INNER_ERROR;
      } elseif ($ret === 1) {
        $ret_body['emr_id'] = $emr_id;
      } else {
        $ret_code = ERR_PARAM_INVALID;
      }
    } else {
      $ret_code = ERR_PARAM_INVALID;
    }
  } // end of `if ($act'
} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
