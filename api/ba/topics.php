<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('ONE_PAGE_ITEMS', 100);

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['ba_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $ba_id = (int)$_GET['ba_id'];
  if ($ba_id <= 0) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $page = 1;
  if (!empty($_GET['p'])) {
    $page = (int)$_GET['p'];
  }

  $topic_brief_list = array();
  $total_num = tb_ba_topic::query_topic_total_num($ba_id);
  if ($total_num > 0
      && ($page - 1) * ONE_PAGE_ITEMS <= $total_num
      && $page >= 1) {
    $topic_list = tb_ba_topic::query_topic_limit($ba_id,
                                                 ($page - 1) * ONE_PAGE_ITEMS,
                                                 ONE_PAGE_ITEMS);
    if ($topic_list === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
    $topic_brief_list = fn_ba_topic::build_topic_brief_list($topic_list);
  }
  $ret_body['list'] = $topic_brief_list;
  $ret_body['total_num'] = $total_num;
  $ret_body['p'] = $page;
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
