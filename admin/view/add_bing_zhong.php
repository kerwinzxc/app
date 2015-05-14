<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $tpl->assign("content_title", "添加病种");
  $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
  $tpl->assign("new_one", 1);
  $tpl->assign("inc_name", "bing_zhong.html");

  $tpl->display("home.html");
}else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $err_msg = '';
  $name = trim($_POST['name']);

  do {
    if (empty($name) || strlen($name) > 39 || strlen($name) < 6) {
      $err_msg = '输入参数错误';
      break;
    }
    if (get_magic_quotes_gpc()) {
      $name = stripslashes($name);
    }

    $new_disease_id = tb_disease::insert_new_one($name);
    if ($new_disease_id === false) {
      $err_msg = "保存数据库失败";
      break;
    }
    $err_msg = "添加成功";
  } while (false);
  alert_and_redirect($err_msg, 'view/add_bing_zhong.php');
}
