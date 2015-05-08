<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

define('ONE_PAGE_ITEMS', 10);

do {
  if (empty($_GET['id'])) {
    $err_msg = "参数错误";
    break;
  }

  $topic_id = $_GET['id'];
  $topic_info = tb_ba_topic::query_topic_by_id($topic_id);
  if ($topic_info === false || empty($topic_info)) {
    $err_msg = "查找该话题失败";
    break;
  }

  $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
  $tpl->assign("id", $topic_id);
  $tpl->assign("topic", $topic_info['topic']);
  $tpl->assign("content", $topic_info['content']);

  $page = 1;
  $total_num = tb_ba_topic_comment::query_topic_comment_total_num($topic_id);
  $comment_list = tb_ba_topic_comment::query_topic_comment_limit($topic_id,
                                                                 ($page - 1) * ONE_PAGE_ITEMS,
                                                                 ONE_PAGE_ITEMS);
  if ($comment_list === false) {
    $err_msg = "查询数据库错误";
    break;
  }
  $comment_list = fn_ba_topic_comment::build_topic_comment_list($comment_list);


  $pages = (int)($total_num / 10) + 1;
  if ($total_num % 10 == 0) {
    $pages -= 1;
  }
  $tpl->assign("comment_list", $comment_list);
  $tpl->assign("total_num",$total_num);
  $tpl->assign("page", $page);
  $tpl->assign("pages", $pages);

  $tpl->assign("content_title", "查看话题");

  $tpl->display("ba_topic_view.html");
  exit;
} while (false);
alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
