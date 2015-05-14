<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

$disease_rows = array();
$page = 1;
$pages = 1;
$total_num = 0;

do {
  if (!isset($_GET['p'])) {
    $page = 1;
  } else {
    $page = (int)$_GET['p'];
  }
  $total_num = tb_disease::query_disease_total_num();
  if (($page - 1) * 10 > $total_num) {
    $page = (int)($total_num / 10) + 1;
  }
  if ($page < 1) { $page = 1; }

  $ret = tb_disease::query_limit(($page - 1) * 10, 10);
  if ($ret === false) {
    $err_msg = '访问数据库失败';
    break;
  }
  foreach ($ret as $row) {
    $r = array();
    $r['id'] = $row['id'];
    $r['name'] = $row['name'];

    $disease_rows[] = $r;
  }

  $pages = (int)($total_num / 10) + 1;
  if ($total_num % 10 == 0) {
    $pages -= 1;
  }
} while (false);

$tpl->assign("refer", $_SERVER['HTTP_REFERER']);
$tpl->assign("content_title", "病种列表");
$tpl->assign("disease_rows", $disease_rows === false ? array() : $disease_rows);
$tpl->assign("inc_name", "bing_zhong_list.html");
$tpl->assign("page", $page);
$tpl->assign("pages", $pages);
$tpl->assign("total_num", $total_num);

$tpl->display("home.html");
