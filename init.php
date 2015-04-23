<?php
/**
 * @author cuisw
 * @create 15 04/04
 */

define('APP_ROOT', __DIR__);
define('LOG_DIR', APP_ROOT . '/logs');
define('ASSETS_BASE_URL', 'http://192.168.0.220/admin/');

require_once APP_ROOT . '/common/error.php';

date_default_timezone_set('PRC');

function class_loader($cls)
{
  $file = APP_ROOT . '/class/' . $cls . '.class.php';
  require_once($file);
}
spl_autoload_register('class_loader');

error_reporting(E_ALL);
