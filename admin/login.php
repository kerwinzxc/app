<?php

session_start();

require_once 'conf/settings.php';
require_once MNG_ROOT . 'libs/smarty/libs/Smarty.class.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

$tpl = new smarty();
$err_msg  = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  do {
    if (empty($_POST['user'])
        || empty($_POST['passwd'])) {
      $err_msg = "user or passwd is empty";
      break;
    }

    $user = $_POST['user'];
    $passwd = $_POST['passwd'];

    if (!preg_match('/^[a-z\d_]{3,20}$/i', $user)) {
      $err_msg = "user error";
      break;
    }
    if (tb_employe::login_auth($user, md5($passwd))) {
      $_SESSION['user'] = array('user' => $user);
      header('Location: view/doctor_entering.php');
      exit;
    }

    $err_msg = "账号或密码错误";
  } while (false);

  alert_and_redirect($err_msg, 'login.php');

} else {
  $tpl->assign("base_url", BASE_URL);
  $tpl->display('login.html');
}
