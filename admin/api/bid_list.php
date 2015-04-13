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
  // ?sid=xxxx
  $sid = $_GET['sid'];

  if (empty($sid))
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

  $bid_list = driver_mb_db::select_yun_dan_my_bid_list($cc_sid_v['uid']);
  if ($bid_list === false)
  {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  
  $ret_list['bid_list'] = $bid_list;

  $cc_sid_v['last_opt_time'] = time();
  cache::set_sid($sid, json_encode($cc_sid_v));

}while (false);

$ret_list['code'] = $ret_code;
$ret_list['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_list);
