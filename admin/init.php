<?php

/**
 * @author cuisw
 * @date 2015-03-03
 * @function ..
 */

session_start();

require_once dirname(__FILE__) . '/conf/settings.php';
require_once ROOT . 'libs/smarty/libs/Smarty.class.php';

date_default_timezone_set("PRC");

if (!isset($_SESSION['user']))
{
  header("Location: " . BASE_URL . "login.php");
  exit;
}

$user = $_SESSION['user'];

$tpl = new smarty();
$tpl->template_dir = ROOT . "templates";
$tpl->compile_dir  = ROOT . "templates_c";
$tpl->assign("user_id", $user['user']);
$tpl->assign("base_url", BASE_URL);
