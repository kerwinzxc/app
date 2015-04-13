<?php

require_once './def.inc.php';
require_once ROOT . 'api/error.inc.php';
require_once ROOT . 'api/check.class.php';
require_once ROOT . 'api/cache.class.php';
require_once ROOT . 'libs/driver_mb_db.inc.php';

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

$ret_code = 0;
$result = array();

do {
  // ?sid=xxxx&order_id=2323424332&price=232323
  $sid = $_GET['sid'];
  $order_id = $_GET['order_id'];
  $price= $_GET['price'];
  $price = (int)$price;

  if (!check::is_order_id($order_id)
    || ($price <= 0 || $price > 10000000))
  {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }else if (empty($sid))
  {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }

  $cc_sid_v = cache::get_sid($sid);
  if (empty($cc_sid_v))
  {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }
  
  $cc_sid_v = json_decode($cc_sid_v, true);
  if (time() - $cc_sid_v['last_opt_time'] > SESSION_LIFE_TIME)
  {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }

  $order_info = driver_mb_db::query_order_by_id($order_id);
  if (empty($order_info))
  {
    $ret_code = ERR_ORDER_NOT_EXIST;
    break;
  }
  
  $cc_sid_v['last_opt_time'] = time();
  cache::set_sid($sid, json_encode($cc_sid_v));

  // do insert bid;
  if (driver_mb_db::insert_yun_dan_bid($order_id,
    $cc_sid_v['uid'],
    time(),
    $price) === false)
  {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  cache::set("newest_order_time", (string)time());
}while (false);

$ret_list['code'] = $ret_code;
$ret_list['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_list);
