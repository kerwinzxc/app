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
  $ret_body['list'] = $ba_list;
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
