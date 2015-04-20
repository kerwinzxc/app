<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('ONE_PAGE_ITEMS', 10);

$ret_code = 0;
$ret_body = array();

do {
  $page = 1;

  if (empty($_GET['topic_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  if (!empty($_GET['p'])) {
    $page = (int)$_GET['p'];
  }

  $topic_id = (int)$_GET['topic_id'];
  if ($topic_id <= 0) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $topic_reply_list = array();
  $total_num = tb_ba_topic_reply::query_topic_reply_total_num($topic_id);
  if ($total_num > 0) {
    if (($page - 1) * ONE_PAGE_ITEMS > $total_num) {
      $page = (int)($total_num / ONE_PAGE_ITEMS);
    }
    if ($page < 1) { $page = 1; }

    $reply_list = tb_ba_topic_reply::query_topic_reply_limit("topic_id=$topic_id",
                                                             'id asc',
                                                             ($page - 1) * ONE_PAGE_ITEMS,
                                                             ONE_PAGE_ITEMS);
    if ($reply_list === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
    $topic_reply_list = fn_ba_topic_reply::build_topic_reply_list($reply_list);
  }
  $ret_body['list'] = $topic_reply_list;
  $ret_body['total_num'] = $total_num;
  $ret_body['p'] = $page;
} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
