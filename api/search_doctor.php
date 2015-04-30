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
  $ke_shi = '';
  $ke_shi_id = 0;
  $hospital = '';
  $name = '';
  $ke_shi_list = array();

  $doctor_list = array();
  $where = '';

  if (!empty($_GET['name'])) {
    $name = $_GET['name'];
    if (get_magic_quotes_gpc()) {
      $name = stripslashes($name);
    }
    $name = util::escape($name);
  }
  if (!empty($_GET['hospital'])) {
    $hospital = $_GET['hospital'];
    if (get_magic_quotes_gpc()) {
      $hospital = stripslashes($hospital);
    }
    $hospital = util::escape($hospital);
  }
  if (!empty($_GET['classify'])) {
    $classify = (int)$_GET['classify'];
  }
  if (!empty($_GET['ke_shi_id'])) {
    $ke_shi_list[] = (int)$_GET['ke_shi_id'];
  } else if (!empty($_GET['ke_shi'])) {
    $ke_shi = $_GET['ke_shi'];
    if (get_magic_quotes_gpc()) {
      $ke_shi = stripslashes($ke_shi);
    }
    $ke_shi = util::escape($ke_shi);
    $ke_shi_list = ke_shi::get_match_id_list($ke_shi);
  }
  if (!empty($_GET['p'])) {
    $page = (int)$_GET['p'];
  }

  // build where
  if ($classify != 0) {
    if (!empty($where)) {
      $where = $where . " and classify=$classify";
    } else {
      $where = "classify=$classify";
    }
  }
  if (!empty($ke_shi_list)) {
    $ke_shi_list = implode(",", $ke_shi_list);
    if (!empty($where)) {
      $where = $where . " and ke_shi in($ke_shi_list)";
    } else {
      $where = "ke_shi in($ke_shi_list)";
    }
  }
  if (!empty($hospital)) {
    if (!empty($where)) {
      $where = $where . " and hospital like '%%{$hospital}%%'";
    } else {
      $where = "hospital like '%%{$hospital}%%'";
    }
  }
  if (!empty($name)) {
    if (!empty($where)) {
      $where = $where . " and name like '%%{$name}%%'";
    } else {
      $where = "name like '%%{$name}%%'";
    }
  }

  $total_num = tb_doctor::query_doctor_total_num($where);
  $doctor_detail_list = array();
  if ($total_num > 0) {
    if (($page - 1) * ONE_PAGE_ITEMS > $total_num) {
      $page = (int)($total_num / ONE_PAGE_ITEMS);
    }
    if ($page < 1) { $page = 1; }

    $doctor_list = tb_doctor::query_doctor_limit($where,
                                                 'id desc', // order by
                                                 ($page - 1) * ONE_PAGE_ITEMS,
                                                 ONE_PAGE_ITEMS);
    if ($doctor_list === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }

    $doctor_detail_list = fn_doctor::build_doctor_detail_list_from_info_list($doctor_list);
  }
  $ret_body['list'] = $doctor_detail_list;
  $ret_body['total_num'] = $total_num;
  $ret_body['p'] = $page;

} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
