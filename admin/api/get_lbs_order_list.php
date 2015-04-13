<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once ROOT . 'libs/driver_mb_db.inc.php';
require_once ROOT . 'libs/crm_db.inc.php';
require_once ROOT . 'libs/func.inc.php';

require_once ROOT . 'api/init.php';
require_once ROOT . 'api/error.inc.php';
require_once ROOT . 'api/check.class.php';

//= method

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

$ret_list = array();
$ret_code = 0;

do {
  $lng = $_GET['lng'];
  $lat = $_GET['lat'];

  // check params
  if ((!empty($lng) && !check::is_coord($lng))
    || (!empty($lat) && !check::is_coord($lat)))
  {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $result = false;
  if (empty($lng) || empty($lat))
    $result = driver_mb_db::select_order(15);
  else
    $result = driver_mb_db::select_lbs_order($lng, $lat);
  if ($result === false)
  {
    $ret_code = ERR_DB_ERROR;
    break;
  }

  $ret_list['orders'] = array();
  foreach ($result as $item)
  {
    $shipper_info = crm_db::query_shipper_by_uid($item['uid']);
    if (empty($shipper_info))
      $item['shipper'] = '';
    else
      $item['shipper'] = $shipper_info['ent_name'];
    $ret_list['orders'][] = $item;
  }
}while (false);

$ret_list['code'] = $ret_code;
$ret_list['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_list);
