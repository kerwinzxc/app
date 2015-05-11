<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

do {
  if (empty($_GET['id'])
    || empty($_GET['doctor_id'])) {
    $err_msg = "参数错误";
    break;
  }

  $video_id = $_GET['id'];
  $video_info = tb_doctor_video::query_video_by_id($video_id);
  if ($video_info === false || empty($video_info)) {
    $err_msg = "查找该文章失败";
    break;
  }

  $doctor_id = $_GET['doctor_id'];
  if ((int)$doctor_id !== (int)$video_info['doctor_id']) {
    $err_msg = "参数不匹配";
    break;
  }
  $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
  if ($doctor_info === false || empty($doctor_info)) {
    $err_msg = "查找该医生失败";
    break;
  }

  $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
  $tpl->assign("id", $video_id);
  $tpl->assign("doctor_id", $doctor_id);
  $tpl->assign("topic", $video_info['topic']);
  $tpl->assign("video_url", $video_info['video_url']);

  $tpl->assign("content_title", "播放视频 - <b>" . $doctor_info['name'] . "</b>");
  $tpl->assign("inc_name", "doctor_video_view.html");

  $tpl->display("home.html");
  exit;
} while (false);
alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
