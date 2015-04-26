<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('ONE_PAGE_ITEMS', 10);

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['doctor_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $page = 1;
  $doctor_id = (int)$_GET['doctor_id'];
  $article_list = array();
  $total_num = tb_doctor_article::query_article_total_num($doctor_id);
  if ($total_num > 0) {
    if (!empty($_GET['p'])) { $page = (int)$_GET['p']; }
    if (($page - 1) * ONE_PAGE_ITEMS > $total_num) {
      $page = (int)($total_num / ONE_PAGE_ITEMS) + 1;
    }
    if ($page < 1) { $page = 1; }

    $article_list = tb_doctor_article::query_article_limit("doctor_id=$doctor_id",
                                                           "id desc",
                                                           ($page - 1) * ONE_PAGE_ITEMS,
                                                           ONE_PAGE_ITEMS);
    if ($article_list === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
    $article_list = fn_doctor_article::build_doctor_article_brief_list($article_list);
  } // end of `if ($total_num > 0)'
  $ret_body['total_num'] = $total_num;
  $ret_body['p'] = $page;
  $ret_body['list'] = $article_list;
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
