<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty

$order_rows = array();
$page = 1;
$pages = 1;
$total_num = 0;

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

if (!isset($_GET['p'])) {
  $page = 1;
} else {
  $page = (int)$_GET['p'];
}

$total_num = tb_tel_ask_order::query_order_num(1);
$order_rows = tb_tel_ask_order::query_order_limit(1,
                                                 ($page - 1) * 10,
                                                 10);
$pages = $total_num / 10 + 1;
if ($total_num % 10 == 0) {
  $pages -= 1;
}

$tpl->assign("refer", $_SERVER['HTTP_REFERER']);
$tpl->assign("content_title", '专线问诊订单');
$tpl->assign("order_rows", $order_rows === false ? array() : $order_rows);
$tpl->assign("inc_name", "tel_order_list.html");
$tpl->assign("page", $page);
$tpl->assign("total_num", $total_num);
$tpl->assign("pages", $pages);

$tpl->display("home.html");
