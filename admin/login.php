<?php

session_start();

require_once 'conf/settings.php';
require_once ROOT . 'libs/smarty/libs/Smarty.class.php';
require_once ROOT . 'libs/crm_db.inc.php';

$tpl = new smarty();
$err_msg  = '';

while ($_POST['user'])
{
  $user = $_POST['user'];
  $passwd = $_POST['passwd'];
  if (empty($user) || empty($passwd))
  {
    $err_msg = "user or passwd is empty";
    break;
  }
  if (!preg_match('/^[a-z\d_]{3,20}$/i', $user))
  {
    $err_msg = "user error";
    break;
  }
  if (crm_db::login_auth($user, $passwd))
  {
    $_SESSION['user'] = array('user' => $user);
    header('Location: view/doctor_entering.php');
  }

  $err_msg = "账号或密码错误";
  break;
}

$tpl->assign("base_url", BASE_URL);
$tpl->assign('err_msg', $err_msg);
$tpl->display('login.html');
