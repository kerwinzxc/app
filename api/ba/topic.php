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

  if ($page <= 1) { // 只在第一次加载时加载话题内容，翻页时就没必要返回了
    $topic_info = tb_ba_topic::query_topic_by_id($topic_id);
    if ($topic_info === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
    if (empty($topic_info)) {
      $ret_code = ERR_BA_TOPIC_NOT_EXIST;
      break;
    }
    fn_ba_topic::build_topic_info($topic_info, $ret_body);
  }

  $comment = array();
  $comment_list = array();
  $total_num = tb_ba_topic_comment::query_topic_comment_total_num($topic_id);
  if ($total_num > 0
      && ($page - 1) * ONE_PAGE_ITEMS <= $total_num
      && $page >= 1) {
    $comment_list = tb_ba_topic_comment::query_topic_comment_limit($topic_id,
                                                                   ($page - 1) * ONE_PAGE_ITEMS,
                                                                   ONE_PAGE_ITEMS);
    if ($comment_list === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
    $comment_list = fn_ba_topic_comment::build_topic_comment_list($comment_list);
  }
  $comment['list'] = $comment_list;
  $comment['total_num'] = $total_num;
  $comment['p'] = $page;
  $ret_body['comment'] = $comment;
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
