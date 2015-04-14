<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/crm_db.inc.php';

$err_msg = '';
$user_name = '';
$user = $_SESSION['user']['user'];

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
  $user_name = crm_db::get_employe_name($user);
  if ($user_name === false)
  {
    unset($_SESSION["user"]); 
    $err_msg = 'query user failed!';
    $user_name = ''; 
  }
}else
{
  while ($_SERVER['REQUEST_METHOD'] == "POST")
  {
    $name = $_POST['name'];
    $passwd = $_POST['passwd'];
    $m_passwd = $_POST['m_passwd'];
    $c_passwd = $_POST['c_passwd'];
    if (strlen($name) < 3 || strlen($name) > 30)
    {
      $err_msg = "name is error";
      break;
    }
    if ($m_passwd != $c_passwd)
    {
      $err_msg = "second passwd is error";
      break;
    }
    if (strlen($m_passwd) < 1 || strlen($m_passwd) > 30)
    {
      $err_msg = "new passwd is error";
      break;
    }
    if (crm_db::login_auth($user, $passwd))
    {
      if (!crm_db::update_employe($user, $name, $m_passwd))
        $err_msg = "修改失败";
      else
      {
        $err_msg = "修改成功";
        unset($_SESSION["user"]); 
      }
    }else
    {
      $err_msg = "原密码错误";
    }

    break;
  }
}

$tpl->assign("err_msg", $err_msg);
$tpl->assign("content_title", S_GE_REN_SHE_ZHI);
$tpl->assign("my_info_title", S_GE_REN_SHE_ZHI);
$tpl->assign("inc_name", "my_settings.html");
$tpl->assign("name", $user_name);
$tpl->display("home.html");
