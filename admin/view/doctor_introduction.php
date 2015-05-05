<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

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

    $doctor_intro = tb_doctor_introduction::query_introduction_by_doctor_id($doctor_id);
    if ($doctor_intro === false) {
      $err_msg = "访问数据库失败";
      break;
    }

    $tpl->assign("doctor_id", $doctor_id);
    $tpl->assign("content", empty($doctor_intro) ? '' : $doctor_intro['content']);
    $tpl->assign("content_title", "医生简介 - <b>" . $doctor_info['name'] . "</b>");

    if (!empty($_GET['edit']))
      $tpl->display("doctor_introduction.html");
    else
      $tpl->display("doctor_introduction_view.html");
    exit;
  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
  do {
    $user = $_SESSION['user']['user'];

    $doctor_id = $_POST['doctor_id'];
    $content = $_POST['editorValue'];

    if (strlen($content) > 12000) {
      $err_msg = "内容太长";
      break;
    }

    if (get_magic_quotes_gpc()) {
      $content = stripslashes($content);
    }
    if (tb_doctor_introduction::update($doctor_id, $content)) {
      $err_msg = "修改成功";
      alert_and_redirect($err_msg, "view/doctor_introduction.php?id=$doctor_id");
    }
    exit;
  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
}
