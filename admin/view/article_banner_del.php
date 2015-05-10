<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

do {
  if (empty($_GET['id'])) {
    $err_msg = "参数错误";
    break;
  }

  $id = $_GET['id'];
  $ret = tb_article_banner::del_one($id);
  if ($ret === false) {
    $err_msg = '访问数据库失败';
    break;
  } else {
    $err_msg = "删除成功";
  }
} while (false);
alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
