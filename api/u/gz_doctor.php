<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('ONE_PAGE_ITEMS', 10);
define('MAX_GZ_DOCTOR_NUMBER', 100);

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['do'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  // check params
  if (empty($_GET['sid'])) {
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
  if ($act == 'get') { // get
    $total_num = tb_user_gz_doctor::query_user_guan_zhu_num($user_id);
    $gl = array();
    $page = 1;
    if ($total_num > 0) {
      if (!empty($_GET['p'])) { $page = (int)$_GET['p']; }
      if (($page - 1) * ONE_PAGE_ITEMS > $total_num) {
        $page = (int)($total_num / ONE_PAGE_ITEMS) + 1;
      }
      if ($page < 1) { $page = 1; }

      $gl = tb_user_gz_doctor::query_user_guan_zhu_list($user_id,
                                                        ($page - 1) * ONE_PAGE_ITEMS,
                                                        ONE_PAGE_ITEMS);
      if ($gl === false) {
        $ret_code = ERR_DB_ERROR;
        break;
      }
      $gl = array_slice($gl, ($page - 1) * ONE_PAGE_ITEMS, ONE_PAGE_ITEMS);
      $gl = fn_doctor::build_doctor_detail_list_from_id_list($gl);
    } // end of `if ($total_num > 0)'
    $ret_body['total_num'] = $total_num;
    $ret_body['p'] = $page;
    $ret_body['list'] = $gl;
  } else { // other need params
    if (empty($_GET['doctor_id'])) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    $doctor_id = (int)$_GET['doctor_id'];
    if ($doctor_id <= 0) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    if ($act == 'add') { // add
      $total_num = tb_user_gz_doctor::query_user_guan_zhu_num($user_id);
      if ($total_num >= MAX_GZ_DOCTOR_NUMBER) {
        $ret_code = ERR_USER_GZ_DOCTOR_LIMIT;
        break;
      }
      if (tb_user_gz_doctor::query_user_had_guan_zhu_or_not($user_id, $doctor_id)) {
        $ret_code = ERR_USER_GZ_DOCTOR_EXIST;
        break;
      }
      $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
      if (empty($doctor_info)) {
        $ret_code = ERR_DOCTOR_NOT_EXIST;
        break;
      }
      if (tb_user_gz_doctor::insert_new_one($user_id, $doctor_id) === false) {
        $ret_code = ERR_DB_ERROR;
        break;
      }
      $ret_body['doctor_id'] = $doctor_id;
    } elseif ($act == 'del') { // del
      if (tb_user_gz_doctor::del_one($user_id, $doctor_id) === false) {
        $ret_code = ERR_DB_ERROR;
        break;
      }
      $ret_body['doctor_id'] = $doctor_id;
    } else {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
  } // end of `if ($act'
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
