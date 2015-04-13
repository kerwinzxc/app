<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once ROOT . 'init.php';
require_once ROOT . 'view/fill_menu_name.inc.php';
require_once ROOT . 'libs/crm_db.inc.php';

$doctor_rows = array();
$page = 1;
$pages = 1;

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

if (!isset($_GET['p'])) {
  $page = 1;
  $pages = array();//crm_db::select_doctor_count();
  $doctor_rows = array();//crm_db::select_doctor(($page-1)*10);
} else {
  $page = $_GET['p'];
  $doctor_id = $_POST['doctor_id'];
  $phone_num = $_POST['phone_num'];
  $name = $_POST['name'];
  $classify = $_POST['classify'];
  $employe_id = $_POST['employe_id'];

  if (!empty($doctor_id)) {
    $tpl->assign("doctor_id", $doctor_id);
    if (!empty($where))
      $where = $where . " and doctor_id like '%%$doctor_id%%'";
    else
      $where = "doctor_id like '%%$doctor_id%%'";
  }

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
$tpl->assign("pages", $pages);

$tpl->display("home.html");
