<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  $ret = tb_disease::query_all();
  if ($ret === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }

  $ret_body['list'] = $ret;

} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
