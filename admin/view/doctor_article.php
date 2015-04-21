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

    $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
    $tpl->assign("id", $doctor_id);
    $tpl->assign("content_title", "添加文章 - <b>" . $doctor_info['name'] . "</b>");
    $tpl->assign("new_one", 1);
    $tpl->assign("inc_name", "doctor_article.html");
    $tpl->assign("h_inc_name", "editor_header.html");

    $tpl->display("home.html");
    exit;
  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
  do {
    $user = $_SESSION['user']['user'];

    $doctor_id = $_POST['id'];
    $topic = $_POST['topic'];
    $content = $_POST['editorValue'];

    if (strlen($topic) > 90
        || strlen($content) > 12000) {
      $err_msg = "标题或内容太长";
      break;
    }

    if (get_magic_quotes_gpc()) {
      $topic = stripslashes($topic);
      $content = stripslashes($content);
    }

    tb_doctor_article::insert_new_one($doctor_id,
                                      $topic,
                                      $content,
                                      time());
    exit;
  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
}
