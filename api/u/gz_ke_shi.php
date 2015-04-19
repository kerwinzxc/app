<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('MAX_GZ_KE_SHI_NUMBER', 20);

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
    $gl = tb_user_gz_ke_shi::query_user_guan_zhu_list($user_id);
    if ($gl === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
    $ret_body['list'] = $gl;
  } elseif ($act == 'add') { // add
    if (empty($_GET['ke_shi'])) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    $to_gz_ke_shi_list = explode(',', $_GET['ke_shi']);
    if (empty($to_gz_ke_shi_list)
        || count($to_gz_ke_shi_list) > MAX_GZ_KE_SHI_NUMBER) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }

    $cur_gz_list = tb_user_gz_ke_shi::query_user_guan_zhu_list($user_id);
    if ($cur_gz_list === false
        || (count($cur_gz_list) + count($to_gz_ke_shi_list)) >= MAX_GZ_KE_SHI_NUMBER) {
      $ret_code = ERR_USER_GZ_KE_SHI_LIMIT;
      break;
    }

    $real_ke_shi_list = array();
    foreach ($to_gz_ke_shi_list as $ke_shi) {
      if (check::is_ke_shi($ke_shi)) {
        $real_ke_shi_list[] = $ke_shi;
      }
    }

    $real_to_gz_list = array_diff($real_ke_shi_list, $cur_gz_list);

    if (!empty($real_to_gz_list)) {
      if (tb_user_gz_ke_shi::insert_some_one($user_id, $real_to_gz_list) === false) {
        $ret_code = ERR_DB_ERROR;
        break;
      }
    }
  } elseif ($act == 'del') { // del
    if (empty($_GET['ke_shi'])) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    $ke_shi = $_GET['ke_shi'];
    if (tb_user_gz_ke_shi::del_one($user_id, $ke_shi) === false) {
      $ret_code = ERR_INNER_ERROR;
      break;
    }
    $ret_body['ke_shi'] = $ke_shi;
  } else {
    $ret_code = ERR_PARAM_INVALID;
    break;
  } // end of `if ($act'
} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
