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
    $tpl->assign("content_title", S_DOCTOR_ARTICLE . " - " . $doctor_info['name']);
    $tpl->assign("new_one", 1);
    $tpl->assign("inc_name", "doctor_article.html");
    $tpl->assign("h_inc_name", "editor_header.html");

    $tpl->display("home.html");
    exit;
  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
  $user = $_SESSION['user']['user'];

  $topic = $_POST['topic'];
  $content = $_POST['editorValue'];

  if (get_magic_quotes_gpc()) {
    $topic = stripslashes($topic);
    $content = stripslashes($content);
  }
}
