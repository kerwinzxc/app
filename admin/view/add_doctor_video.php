<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

$err_msg = '';
if ($_SERVER['REQUEST_METHOD'] == "GET") {
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

    $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
    $tpl->assign("doctor_id", $doctor_id);
    $tpl->assign("content_title", "添加视频 - <b>" . $doctor_info['name'] . "</b>");
    $tpl->assign("new_one", 1);
    $tpl->assign("inc_name", "doctor_video.html");

    $tpl->display("home.html");
    exit;
  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
  do {
    $user = $_SESSION['user']['user'];

    if (empty($_POST['doctor_id'])
        || empty($_POST['topic'])) {
      $err_msg = '参数错误';
      break;
    }

    $topic = $_POST['topic'];
    if (get_magic_quotes_gpc()) {
      $topic = stripslashes($topic);
    }
    $doctor_id = $_POST['doctor_id'];

    $err_msg = '';
    $filename = '';
    $video = 'video';
    if (!empty($_FILES[$video]["name"])) {
      $filename = $_FILES[$video]["name"];
      if ($_FILES[$video]["error"] > 0) {
        $err_msg = 'Return Code: ' . $_FILES[$video]["error"];
        break;
      }
      if ($_FILES[$video]["size"] > 50*1024*1024) {
        $err_msg = $filename . " 视频大小超出限制(2M)";
        break;
      }
      $filename = md5($user . $doctor_id . time())
        . "."
        . util::get_file_ext($filename);

      move_uploaded_file($_FILES[$video]['tmp_name'], MNG_ROOT . 'video/' . $filename);
    } else {
      $err_msg = '视频不能为空';
      break;
    }
    if ($err_msg != '') {
      break;
    }
    // upload end

    $new_video_id = tb_doctor_video::insert_new_one($doctor_id,
                                                    $topic,
                                                    $filename,
                                                    time());
    if ($new_video_id !== false) {
      $err_msg = "添加成功!";
      alert_and_redirect($err_msg, "view/doctor_video_view.php?id=$new_video_id&doctor_id=$doctor_id");
    }
  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
}
