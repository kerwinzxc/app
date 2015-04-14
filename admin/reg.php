<?php

require_once dirname(__FILE__) . '/conf/settings.php';
require_once MNG_ROOT . 'libs/smarty/libs/Smarty.class.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

date_default_timezone_set("PRC");

$tpl = new smarty();
$err_msg = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  do {
    $user = $_POST['user'];
    $name = $_POST['name'];
    if (!check::is_user($user)
        || !check::is_name($name)) {
      $err_msg = "用户或姓名不对";
      break;
    }

    if (tb_employe::query_employe_is_exist($user)) {
      $err_msg = "账户已存在";
      break;
    } else {
      if (!tb_employe::insert_new_one($user, md5('000000'), $name, time())) {
        $err_msg = "注册失败";
        break;
      } else {
        $err_msg = "注册成功";
        alert_and_redirect($err_msg, 'login.php');
      }
    }
  } while (false);
  alert_and_redirect($err_msg, 'reg.php');
} else {
  $tpl->display('reg.html');
}
