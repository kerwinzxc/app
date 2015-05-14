<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('MAX_GZ_BA_NUMBER', 20);

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
    $gl = tb_user_gz_ba::query_user_guan_zhu_list($user_id);
    if ($gl === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
    $ba_detail_list = array();
    foreach ($gl as $ba_id) {
      $ba = tb_ba::query_ba_by_id($ba_id);
      if (!empty($ba)) {
        $ba_info = array();
        $ba_info['ba_id'] = $ba['id'];
        $ba_info['name'] = $ba['name'];
        $ba_info['icon_url'] = $ba['icon_url'];
        $gz_num = tb_user_gz_ba::query_gz_ba_num($ba['id']);
        $ba_info['gz_num'] = empty($gz_num) ? 0 : $gz_num;
        $ba_detail_list[] = $ba_info;
      }
    }
    $ret_body['list'] = $ba_detail_list;
  } else { // other need params
    if (empty($_GET['ba_id'])) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    $ba_id = (int)$_GET['ba_id'];
    if ($ba_id <= 0) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    if ($act == 'add') { // add
      $had_gz_list = tb_user_gz_ba::query_user_guan_zhu_list($user_id);
      if ($had_gz_list === false
          || count($had_gz_list) >= MAX_GZ_BA_NUMBER) {
        $ret_code = ERR_USER_GZ_BA_LIMIT;
        break;
      }
      if (!in_array($ba_id, $had_gz_list)) {
        if (tb_user_gz_ba::insert_new_one($user_id, $ba_id) === false) {
          $ret_code = ERR_DB_ERROR;
          break;
        }
      }
      $ret_body['ba_id'] = $ba_id;
    } elseif ($act == 'del') { // del
      if (tb_user_gz_ba::del_one($user_id, $ba_id) === false) {
        $ret_code = ERR_INNER_ERROR;
        break;
      }
      $ret_body['ba_id'] = $ba_id;
    } elseif ($act == 'had_gz') { // had guan zhu
      $had_gz_list = tb_user_gz_ba::query_user_guan_zhu_list($user_id);
      if ($had_gz_list === false) {
        $ret_code = ERR_DB_ERROR;
        break;
      }
      if (!in_array($ba_id, $had_gz_list)) {
        $ret_body['had_gz'] = 0;
      } else {
        $ret_body['had_gz'] = 1;
      }
    } else {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
  } // end of `if ($act'
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
