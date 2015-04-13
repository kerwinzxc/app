<?php

require_once './def.inc.php';
require_once ROOT . 'api/error.inc.php';
require_once ROOT . 'libs/driver_mb_db.inc.php';
require_once ROOT . 'api/check.class.php';

require_once ROOT . 'api/init.php';

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

$order_id = $_GET['order_id'];

$ret_code = 0;
$result = array();

if (!check::is_order_id($order_id))
  $ret_code = ERR_PARAM_INVALID;
else
{
  $ret = driver_mb_db::query_order_by_id($order_id);
  if ($ret === false || empty($ret))
    $ret_code = ERR_ORDER_NOT_EXIST;
  else
    $result['order'] = $ret;
}
$result['code'] = $ret_code;
$result['desc'] = $ERRORS[$ret_code];

echo json_encode($result);
