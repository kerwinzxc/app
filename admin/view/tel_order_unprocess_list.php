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

$total_num = tb_tel_ask_order::query_total_num('state=1');
$orders = tb_tel_ask_order::query_limit('state=1',
                                       ($page - 1) * 10,
                                       10);
$order_rows = array();
foreach ($orders as $item) {
  $order = array();
  $doctor_info = tb_doctor::query_doctor_by_id($item['doctor_id']);
  if (!empty($doctor_info)) {
    $order['doctor'] = $doctor_info['name'];
  } else {
    $order['doctor'] = '';
  }
  $order['doctor_id']  = $item['doctor_id'];
  $order['id']  = $item['id'];
  $order['patient']  = $item['name'];
  $order['expected_time_b'] = $item['expected_time_b'];
  $order['expected_time_e'] = $item['expected_time_e'];
  $order['disease_desc'] = $item['disease_desc'];
  $order['phone_num'] = $item['phone_num'];

  $urls = array();
  if (!empty($item['emr_url'])) {
    $urls = explode(";", $item['emr_url']);
  }
  $order['emr_url'] = $urls;

  $order_rows[] = $order;
}
$pages = $total_num / 10 + 1;
if ($total_num % 10 == 0) {
  $pages -= 1;
}

$tpl->assign("refer", $_SERVER['HTTP_REFERER']);
$tpl->assign("content_title", '在线问诊订单');
$tpl->assign("order_rows", $order_rows === false ? array() : $order_rows);
$tpl->assign("inc_name", "tel_order_list.html");
$tpl->assign("page", $page);
$tpl->assign("total_num", $total_num);
$tpl->assign("pages", $pages);

$tpl->display("home.html");
