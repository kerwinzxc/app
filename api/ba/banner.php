<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  $ret = tb_ba_banner::query_ba_banner_list();
  if ($ret === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $banner_list = array();
  foreach ($ret as $banner) {
    $banner_info = array();
    $banner_info['img_url'] = $banner['img_url'];

    $target = json_decode($banner['target'], true);
    if (!empty($target)) {
      $ba_info = tb_ba::query_ba_by_id($target['ba_id']);
      if (!empty($ba_info)) {
        $target['name'] = $ba_info['name'];
      }
    }
    $banner_info['target'] = $target;

    $banner_list[] = $banner_info;
  }
  $ret_body['list'] = $banner_list;
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
