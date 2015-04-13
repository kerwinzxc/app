<?php

require_once dirname(__FILE__) . '/conf/settings.php';
require_once ROOT . 'libs/smarty/libs/Smarty.class.php';
require_once ROOT . 'libs/crm_db.inc.php';
require_once ROOT . 'libs/func.inc.php';

$tpl = new smarty();
$err_msg = "";

while ($_SERVER['REQUEST_METHOD'] == "POST")
{
  $user = $_POST['user'];
  $name = $_POST['name'];
  if (strlen($name) < 3 || strlen($name) > 30)
  {
    $err_msg = "姓名长度不符";
    break;
  }
  if (!check_reg_user($user))
  {
    $err_msg = "用户格式错误";
    break;
  }

  if (crm_db::reg_user_is_exist($user))
  {
    $err_msg = "账户已存在";
  }else
  {
    if (!crm_db::insert_employe($user, $name))
      $err_msg = "注册失败";
    else
      $err_msg = "注册成功";
  }
  
  break;
}

$tpl->assign('err_msg', $err_msg);
$tpl->display('reg.html');
