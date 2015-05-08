<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  $ba_list = tb_ba::query_ba_all_open_list();
  if ($ba_list === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $ba_detail_list = array();
  foreach ($ba_list as $ba) {
    $ba_info = array();
    $ba_info['ba_id'] = $ba['id'];
    $ba_info['name'] = $ba['name'];
    $ba_info['icon_url'] = $ba['icon_url'];
    $gz_num = tb_user_gz_ba::query_gz_ba_num($ba['id']);
    $ba_info['gz_num'] = empty($gz_num) ? 0 : $gz_num;
    $ba_detail_list[] = $ba_info;
  }
  $ret_body['list'] = $ba_detail_list;
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
