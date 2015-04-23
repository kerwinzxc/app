<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

$page = 1;
$pages = 1;
$total_num = 0;

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

if (!isset($_GET['p'])) {
  $page = 1;
} else {
  $page = (int)$_GET['p'];
}

do {
  if (empty($_GET['id'])) {
    $err_msg = "参数错误";
    break;
  }

  $doctor_id = $_GET['id'];
  $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
  if ($doctor_info === false || empty($doctor_info)) {
    $err_msg = "查找该医生失败";
    break;
  }
  $total_num = tb_doctor_video::query_video_total_num($doctor_id);
  if (($page - 1) * 10 > $total_num) {
    $page = (int)($total_num / 10) + 1;
  }
  if ($page < 1) { $page = 1; }

  $video_list = tb_doctor_video::query_video_limit("doctor_id=$doctor_id",
                                                   'id desc',
                                                   ($page - 1) * 10,
                                                   10);
  if ($video_list === false) {
    $err_msg = '访问数据库失败';
    break;
  }
  $pages = (int)($total_num / 10) + 1;
  if ($total_num % 10 == 0) {
    $pages -= 1;
  }

  $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
  $tpl->assign("id", $doctor_id);
  $tpl->assign("total_num", $total_num);
  $tpl->assign("page", $page);
  $tpl->assign("pages", $pages);
  $tpl->assign("video_rows", $video_list);

  $tpl->assign("content_title", "文章列表 - <b>" . $doctor_info['name'] . "</b>");
  $tpl->assign("new_one", 1);
  $tpl->assign("inc_name", "doctor_video_list.html");
  //$tpl->assign("h_inc_name", "editor_header.html");

  $tpl->display("home.html");
  exit;
} while (false);
alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);

