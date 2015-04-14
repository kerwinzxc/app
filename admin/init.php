<?php

/**
 * @author cuisw
 * @date 2015-03-03
 * @function ..
 */

session_start();

require_once __DIR__ . '/conf/settings.php';
require_once MNG_ROOT . 'libs/smarty/libs/Smarty.class.php';

date_default_timezone_set("PRC");

if (!isset($_SESSION['user']))
{
  header("Location: " . BASE_URL . "login.php");
  exit;
}

$user = $_SESSION['user'];

$tpl = new smarty();
$tpl->template_dir = MNG_ROOT . "templates";
$tpl->compile_dir  = MNG_ROOT . "templates_c";
$tpl->assign("user_id", $user['user']);
$tpl->assign("base_url", BASE_URL);
