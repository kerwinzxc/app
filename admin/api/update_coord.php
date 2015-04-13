<?php

require_once './def.inc.php';

require_once ROOT . 'api/error.inc.php';
require_once ROOT . 'libs/driver_mb_db.inc.php';
require_once ROOT . 'api/check.class.php';
require_once ROOT . 'api/cache.class.php';

require_once ROOT . 'api/init.php';

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

$ret_code = 0;
$result = array();

do {
  // ?sid=xxxx&lng=111.223323&lat=12.232323
  $sid = $_GET['sid'];
  $lng = $_GET['lng'];
  $lat = $_GET['lat'];

  if (!check::is_coord($lng) || !check::is_coord($lat))
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
  }else
  {
    $cc_sid_v = json_decode($cc_sid_v, true);
    if (time() - $cc_sid_v['last_opt_time'] > SESSION_LIFE_TIME)
    {
      $ret_code = ERR_NOT_LOGIN;
      break;
    }else
    {
      if (driver_mb_db::update_driver_coord($cc_sid_v['phone_num'], $lng, $lat) !== false)
      {
        $cc_sid_v['last_opt_time'] = time();
        $cc_sid_v['lng'] = $lng;
        $cc_sid_v['lat'] = $lat;
        cache::set_sid($sid, json_encode($cc_sid_v));
      }else
      {
        $ret_code = ERR_DB_ERROR;
        break;
      }
    }
  }
}while (false);

$result['code'] = $ret_code;
$result['desc'] = $ERRORS[$ret_code];

echo json_encode($result);
