<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('ONE_PAGE_ITEMS', 10);

$ret_code = 0;
$ret_body = array();

do {
  $page = 0;

  if (empty($_GET['ba_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  if (!empty($_GET['p'])) {
    $page = (int)$_GET['p'];
  }

  $ba_id = (int)$_GET['ba_id'];
  if ($ba_id <= 0) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $total_num = tb_ba_topic::query_topic_total_num($ba_id);
  if ($total_num > 0) {
    if (($page - 1) * ONE_PAGE_ITEMS > $total_num) {
      $page = (int)($total_num / ONE_PAGE_ITEMS);
    }
    if ($page < 1) { $page = 1; }

    $topic_list = tb_ba_topic::query_topic_limit("ba_id=$ba_id",
                                                 'useful desc, id asc',
                                                 ($page - 1) * ONE_PAGE_ITEMS,
                                                 ONE_PAGE_ITEMS);
    if ($topic_list === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
    $ret_body['list'] = fn_ba_topic::build_topic_brief_list($topic_list);
    $ret_body['total_num'] = $total_num;
  } else {
    $ret_body['list'] = array();
    $ret_body['total_num'] = 0;
  }

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
