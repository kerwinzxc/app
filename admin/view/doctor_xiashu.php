<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty

$doctor_rows = array();
$page = 1;
$pages = 1;
$total_num = 0;

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

if (!isset($_GET['p'])) {
  $page = 1;
} else {
  $page = (int)$_GET['p'];
}

$master_id = $_GET['master_id'];
$where = '';

if (!empty($master_id)) {
  if (!empty($where)) {
    $where = $where . " and master_id='$master_id'";
  } else {
    $where = "master_id='$master_id'";
  }
}
if (!empty($where)) {
  $total_num = tb_doctor::query_doctor_total_num($where);
  $doctor_rows = tb_doctor::query_doctor_limit($where,
                                               'id desc',
                                               ($page - 1) * 10,
                                               10);
  $pages = (int)($total_num / 10) + 1;
  if ($total_num % 10 == 0) {
    $pages -= 1;
  }
}

$tpl->assign("refer", $_SERVER['HTTP_REFERER']);
$tpl->assign("content_title", "下属列表");
$tpl->assign("doctor_rows", $doctor_rows === false ? array() : $doctor_rows);
$tpl->assign("inc_name", "doctor_query.html");
$tpl->assign("page", $page);
$tpl->assign("total_num", $total_num);
$tpl->assign("pages", $pages);

$tpl->display("home.html");
