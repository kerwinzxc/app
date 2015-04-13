<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once ROOT . 'init.php';
require_once ROOT . 'view/fill_menu_name.inc.php';

require_once ROOT . 'autoload.php'; // below smarty

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

if (!isset($_GET['kw'])) {
  $total_num = tb_doctor::query_doctor_total_num();
  $doctor_rows = tb_doctor::query_doctor_limit(($page - 1) * 10);
  $pages = $total_num / 10 + 1;
  if ($total_num % 10 == 0) {
    $pages -= 1;
  }
} else {
  $page = $_GET['p'];
  $phone_num = $_POST['phone_num'];
  $name = $_POST['name'];
  $classify = $_POST['classify'];
  $employe_id = $_POST['employe_id'];

  if (!empty($phone_num)) {
    $tpl->assign("phone_num", $phone_num);
    if (!empty($where))
      $where = $where . " and phone_num='$phone_num'";
    else
      $where = "phone_num='$phone_num'";
  }
  if (!empty($name)) {
    $tpl->assign("name", $name);
    if (!empty($where))
      $where = $where . " and name='$name'";
    else
      $where = "name='$name'";
  }
  if (!empty($classify) && is_numeric($classify)) {
    $tpl->assign("classify", $classify);
    if (!empty($where))
      $where = $where . " and classify=$classify";
    else
      $where = "classify=$classify";
  }
  if (!empty($employe_id)) {
    $tpl->assign("employe_id", $employe_id);
    if (!empty($where))
      $where = $where . " and employe_id='$employe_id'";
    else
      $where = "employe_id='$employe_id'";
  }
  if (!empty($where)) {
    $doctor_rows = crm_db::query_doctor($where, ($page-1)*10);
    $pages = count($doctor_rows)/10;
  }
}

$tpl->assign("content_title", S_DOCTOR_CHA_XUN);
$tpl->assign("doctor_rows", $doctor_rows === false ? array() : $doctor_rows);
$tpl->assign("inc_name", "doctor_query.html");
$tpl->assign("page", $page);
$tpl->assign("total_num", $total_num);
$tpl->assign("pages", $pages);

$tpl->display("home.html");
