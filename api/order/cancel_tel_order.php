<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('ONE_PAGE_ITEMS', 10);

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['order_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $order_id = (int)$_GET['order_id'];
  if ($order_id <= 0) {
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

  $order = tb_tel_ask_order::query_order_by_id($order_id);
  if ($order === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  if (empty($order)
      || (int)$order['user_id'] != $order_id) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  tb_tel_ask_order::set_state($order_id, 2);

} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
