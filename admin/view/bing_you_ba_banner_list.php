<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

$banner_rows = array();

do {
  $ret = tb_ba_banner::query_ba_banner_list();
  if ($ret === false) {
    $err_msg = '访问数据库失败';
    break;
  }
  foreach ($ret as $row) {
    $r = array();
    $r['id'] = $row['id'];
    $r['priority'] = $row['priority'];
    $r['img_url'] = $row['img_url'];
    $r['target'] = json_decode($row['target'], true);

    $banner_rows[] = $r;
  }
} while (false);
$tpl->assign("refer", $_SERVER['HTTP_REFERER']);
$tpl->assign("content_title", "病友推广图列表");
$tpl->assign("banner_rows", $banner_rows === false ? array() : $banner_rows);
$tpl->assign("inc_name", "bing_you_ba_banner_list.html");

$tpl->display("home.html");
