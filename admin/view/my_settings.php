<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

$err_msg = '';
$user = $_SESSION['user']['user'];
$user_name = '';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $employe_info = tb_employe::query_employe_by_id($user);
  if ($employe_info === false) {
    unset($_SESSION["user"]); 
    $err_msg = 'query user failed!';
  } else {
    $user_name = $employe_info['name'];
  }
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
  do {
    $passwd = $_POST['passwd'];
    $m_passwd = $_POST['m_passwd'];
    $c_passwd = $_POST['c_passwd'];
    if ($m_passwd != $c_passwd) {
      $err_msg = "两次密码不一致";
      break;
    }
    if (!check::is_passwd($m_passwd)) {
      $err_msg = "新密码格式不正确";
      break;
    }
    if (tb_employe::login_auth($user, $passwd)) {
      if (!tb_employe::update_passwd($user, $m_passwd)) {
        $err_msg = "修改失败";
      } else {
        $err_msg = "修改成功";
        unset($_SESSION["user"]); 
        alert_and_redirect($err_msg, 'login.php');
        break;
      }
    } else {
      $err_msg = "原密码错误";
    }
  } while (false);
  alert_and_redirect($err_msg, 'login.php');
}

$tpl->assign("err_msg", $err_msg);
$tpl->assign("content_title", S_GE_REN_SHE_ZHI);
$tpl->assign("my_info_title", S_GE_REN_SHE_ZHI);
$tpl->assign("inc_name", "my_settings.html");
$tpl->assign("name", $user_name);
$tpl->display("home.html");
