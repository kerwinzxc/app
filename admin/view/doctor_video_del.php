<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

do {
  if (empty($_GET['id'])) {
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

  $video_list = tb_doctor_video::del_one($video_id, $doctor_id);
  if ($video_list === false) {
    $err_msg = '访问数据库失败';
    break;
  } else {
    unlink(MNG_ROOT . 'video/' . $video_info['video_url']);
    $err_msg = "删除成功";
  }
} while (false);
alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
