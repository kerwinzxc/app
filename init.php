<?php
/**
 * @author cuisw
 * @create 15 04/04
 */

define('ROOT', __DIR__);
define('LOG_DIR', ROOT . '/logs');

require_once ROOT . '/common/error.php';

date_default_timezone_set('PRC');

function class_loader($cls)
{
  $file = ROOT . '/class/' . $cls . '.class.php';
  require_once($file);
}
spl_autoload_register('class_loader');
