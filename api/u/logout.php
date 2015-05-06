<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['sid'])
      || !user_session::is_sid($_GET['sid'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $sid = $_GET['sid'];
  user_session::del_session($sid);
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
