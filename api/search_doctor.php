<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('ONE_PAGE_ITEMS', 10);

$ret_code = 0;
$ret_body = array();

do {
  $total_num = 0;
  $page = 1;
  $classify = 0;
  $ke_shi = 0;
  $hospital = '';
  $name = '';

  $doctor_list = array();
  $where = '';

  if (!empty($_GET['classify'])) {
    $classify = (int)$_GET['classify'];
  }
  if (!empty($_GET['ke_shi'])) {
    $ke_shi = (int)$_GET['ke_shi'];
  }
  if (!empty($_GET['hospital'])) {
    $hospital = $_GET['hospital'];
    if (get_magic_quotes_gpc()) {
      $hospital = stripslashes($hospital);
    }
  }
  if (!empty($_GET['name'])) {
    $name = $_GET['name'];
    if (get_magic_quotes_gpc()) {
      $name = stripslashes($name);
    }
  }
  if (!empty($_GET['p'])) {
    $page = (int)$_GET['p'];
  }
  if ($classify != 0) {
    if (!empty($where)) {
      $where = $where . " and classify=$classify";
    } else {
      $where = "classify=$classify";
    }
  }
  if ($ke_shi != 0) {
    if (!empty($where)) {
      $where = $where . " and ke_shi=$ke_shi";
    } else {
      $where = "ke_shi=$ke_shi";
    }
  }
  if (!empty($hospital)) {
    $hospital = util::escape($hospital);
    if (!empty($where)) {
      $where = $where . " and hospital like '%%{$hospital}%%'";
    } else {
      $where = "hospital like '%%{$hospital}%%'";
    }
  }
  if (!empty($name)) {
    $name = util::escape($name);
    if (!empty($where)) {
      $where = $where . " and name like '%%{$name}%%'";
    } else {
      $where = "name like '%%{$name}%%'";
    }
  }

  $total_num = tb_doctor::query_doctor_total_num($where);
  if ($total_num > 0) {
    if (($page - 1) * ONE_PAGE_ITEMS > $total_num) {
      $page = $total_num / ONE_PAGE_ITEMS;
    }
    $page = $page < 1 ? 1 :$page;

    $doctor_list = tb_doctor::query_doctor_limit($where,
                                                 'id desc', // order by
                                                 ($page - 1) * ONE_PAGE_ITEMS,
                                                 ONE_PAGE_ITEMS);
    if ($doctor_list === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }

    $ret_body['list'] = fn_doctor::build_doctor_detail_list($doctor_list);
    $ret_body['total_num'] = $total_num;
  } else {
    $ret_body['list'] = array();
    $ret_body['total_num'] = 0;
  }

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
