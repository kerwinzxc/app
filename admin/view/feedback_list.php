<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty

$feedback_rows = array();
$page = 1;
$pages = 1;
$total_num = 0;

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

if (!isset($_GET['p'])) {
  $page = 1;
} else {
  $page = (int)$_GET['p'];
}

$total_num = tb_feedback::query_total_num();
$feedback_rows = tb_feedback::query_limit(($page - 1) * 10, 10);
$pages = $total_num / 10 + 1;
if ($total_num % 10 == 0) {
  $pages -= 1;
}

$tpl->assign("refer", $_SERVER['HTTP_REFERER']);
$tpl->assign("content_title", '意见反馈');
$tpl->assign("feedback_rows", $feedback_rows === false ? array() : $feedback_rows);
$tpl->assign("inc_name", "feedback_list.html");
$tpl->assign("page", $page);
$tpl->assign("total_num", $total_num);
$tpl->assign("pages", $pages);

$tpl->display("home.html");
