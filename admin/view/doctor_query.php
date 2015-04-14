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

if (!isset($_GET['kw'])) {
  $total_num = tb_doctor::query_doctor_total_num('');
  $doctor_rows = tb_doctor::query_doctor_limit('',
      'id desc',
      ($page - 1) * 10,
      10);
  $pages = $total_num / 10 + 1;
  if ($total_num % 10 == 0) {
    $pages -= 1;
  }
} else {
  $phone_num = $_GET['phone_num'];
  $name = $_GET['name'];
  $classify = $_GET['classify'];
  $phone_num = $_GET['phone_num'];
  $employe_id = $_GET['employe_id'];
  $where = '';

  if (!empty($phone_num)) {
    $tpl->assign("phone_num", $phone_num);
    if (!empty($where)) {
      $where = $where . " and phone_num='$phone_num'";
    } else {
      $where = "phone_num='$phone_num'";
    }
  }
  if (!empty($name)) {
    $tpl->assign("name", $name);
    if (!empty($where)) {
      $where = $where . " and name like '%%{$name}%%'";
    } else {
      $where = "name='$name'";
    }
  }
  if (!empty($classify) && is_numeric($classify)) {
    $tpl->assign("classify", $classify);
    if (!empty($where)) {
      $where = $where . " and classify=$classify";
    } else {
      $where = "classify=$classify";
    }
  }
  if (!empty($employe_id)) {
    $tpl->assign("employe_id", $employe_id);
    if (!empty($where)) {
      $where = $where . " and employe_id='$employe_id'";
    } else {
      $where = "employe_id='$employe_id'";
    }
  }
  if (!empty($where)) {
    $total_num = tb_doctor::query_doctor_total_num($where);
    $doctor_rows = tb_doctor::query_doctor_limit($where,
        'id desc',
        ($page - 1) * 10,
        10);
    $pages = $total_num / 10 + 1;
    if ($total_num % 10 == 0) {
      $pages -= 1;
    }
  }
}

$tpl->assign("content_title", S_DOCTOR_CHA_XUN);
$tpl->assign("doctor_rows", $doctor_rows === false ? array() : $doctor_rows);
$tpl->assign("inc_name", "doctor_query.html");
$tpl->assign("page", $page);
$tpl->assign("total_num", $total_num);
$tpl->assign("pages", $pages);

$tpl->display("home.html");
