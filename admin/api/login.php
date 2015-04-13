<?php

require_once './def.inc.php';
require_once ROOT . 'api/error.inc.php';
require_once ROOT . 'api/util.class.php';
require_once ROOT . 'api/check.class.php';
require_once ROOT . 'api/cache.class.php';
require_once ROOT . 'libs/driver_mb_db.inc.php';

if ($_SERVER['REQUEST_METHOD'] != "POST") exit;

$phone_num   = $_POST['user'];
$passwd = $_POST['passwd'];

$result = array();
$ret_code = 0;

do {
  if (!check::is_phone_num($phone_num) || !check::is_passwd($passwd))
  {
    $ret_code = ERR_USER_PASSWD_ERR;
    break;
  }else
  {
    $passwd = md5($passwd);
    // TODO use redis;
    $driver_info = driver_mb_db::query_driver_by_phone_num($phone_num);
    if (empty($driver_info)
      || $passwd != $driver_info['passwd'])
    {
      $ret_code = ERR_USER_PASSWD_ERR;
      break;
    }

    $sid = util::generate_sid(); 

    $sid_val = array('last_opt_time' => time(),
      'uid' => $driver_info['uid'],
      'phone_num' => $driver_info['phone_num'],
      'lng' => '',
      'lat' => '',
    );
    if (cache::set_sid($sid, json_encode($sid_val)) !== true)
    {
      $ret_code = ERR_CACHE_CONNECT_FAIL;
      break;
    }
    $result['sid'] = $sid;
  }
}while (false);

$result['code'] = $ret_code;
$result['desc'] = $ERRORS[$ret_code];

echo json_encode($result);
