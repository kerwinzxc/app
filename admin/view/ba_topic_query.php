<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty

$topic_rows = array();
$page = 1;
$pages = 1;
$total_num = 0;

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

$err_msg = '';
do {
  if (empty($_GET['id'])) {
    $err_msg = "参数错误";
    break;
  }
  $ba_id = (int)$_GET['id'];

  if (!isset($_GET['p'])) {
    $page = 1;
  } else {
    $page = (int)$_GET['p'];
  }
  $ba_info = tb_ba::query_ba_by_id($ba_id);
  if ($ba_info === false || empty($ba_info)) {
    $err_msg = "query failed";
    break;
  }

  if (!isset($_GET['kw'])) {
    $total_num = tb_ba_topic::query_topic_total_num($ba_id);
    $topic_rows = tb_ba_topic::query_topic_limit_ex("ba_id=$ba_id",
                                                    ($page - 1) * 10,
                                                    10);
    $pages = (int)($total_num / 10) + 1;
    if ($total_num % 10 == 0) {
      $pages -= 1;
    }
  } else {
    $topic = $_GET['topic'];
    $where = "ba_id=$ba_id";

    if (!empty($topic)) {
      $tpl->assign("topic", $topic);
      if (!empty($where)) {
        $where = $where . " and topic like '%%{$topic}%%'";
      } else {
        $where = "topic like '%%{$topic}%%'";
      }
    }
    if (!empty($where)) {
      $total_num = tb_ba_topic::query_topic_total_num($ba_id);
      $topic_rows = tb_ba_topic::query_topic_limit_ex($where,
                                                      ($page - 1) * 10,
                                                      10);
      $pages = (int)($total_num / 10) + 1;
      if ($total_num % 10 == 0) {
        $pages -= 1;
      }
    }
  }

  $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
  $tpl->assign("content_title", $ba_info['name']);
  $tpl->assign("id", $ba_id);
  $tpl->assign("topic_rows", $topic_rows === false ? array() : $topic_rows);
  $tpl->assign("inc_name", "ba_topic_query.html");
  $tpl->assign("page", $page);
  $tpl->assign("total_num", $total_num);
  $tpl->assign("pages", $pages);

  $tpl->display("home.html");
  exit;
} while (false);

alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
