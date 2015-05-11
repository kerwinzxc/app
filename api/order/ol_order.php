<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('ONE_PAGE_ITEMS', 10);

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
  if ($act == 'get_list') { // get list
    $total_num = tb_ol_ask_order::query_order_num($user_id);
    $order_list = array();
    $page = 1;
    if ($total_num > 0) {
      if (!empty($_GET['p'])) { $page = (int)$_GET['p']; }
      if (($page - 1) * ONE_PAGE_ITEMS <= $total_num
          && $page >= 1) {
        $order_list = tb_ol_ask_order::query_order_limit($user_id,
                                                         ($page - 1) * ONE_PAGE_ITEMS,
                                                         ONE_PAGE_ITEMS);
        if ($order_list === false) {
          $ret_code = ERR_DB_ERROR;
          break;
        }
        $order_list = fn_ol_ask_order::build_order_brief_list($order_list);
      }
    } // end of `if ($total_num > 0)'
    $ret_body['total_num'] = $total_num;
    $ret_body['p'] = $page;
    $ret_body['list'] = $order_list;
  } else { // other need params
    if (empty($_GET['order_id'])) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    $order_id = (int)$_GET['order_id'];
    if ($order_id <= 0) {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
    if ($act == 'del') { // del
      $order_info = tb_ol_ask_order::query_order_by_id($order_id);
      if ($order_info === false) {
        $ret_code = ERR_DB_ERROR;
        break;
      } elseif (empty($order_info)) {
        $ret_code = ERR_ORDER_NOTI_EXIST;
        break;
      } else if ((int)$order_info['user_id'] !== (int)$user_id) {
        $ret_code = ERR_PARAM_INVALID;
        break;
      }
      if (tb_ol_ask_order::del_one($order_id) === false) {
        $ret_code = ERR_INNER_ERROR;
        break;
      }
    } else {
      $ret_code = ERR_PARAM_INVALID;
      break;
    }
  } // // end of `if ($act'
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
