<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  do {
    if (empty($_GET['id'])
      || empty($_GET['doctor_id'])) {
      $err_msg = "参数错误";
      break;
    }
    $article_id = $_GET['id'];
    $doctor_id = $_GET['doctor_id'];
    $article_info = tb_doctor_article::query_article_by_id($article_id);
    if ($article_info === false || empty($article_info)) {
      $err_msg = "查找该文章失败";
      break;
    }

    $doctor_id = $_GET['doctor_id'];
    if ((int)$doctor_id !== (int)$article_info['doctor_id']) {
      $err_msg = "参数不匹配";
      break;
    }
    $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
    if ($doctor_info === false || empty($doctor_info)) {
      $err_msg = "查找该医生失败";
      break;
    }

    $tpl->assign("id", $article_id);
    $tpl->assign("doctor_id", $doctor_id);
    $tpl->assign("topic", $article_info['topic']);
    $tpl->assign("article_type", $article_info['article_type']);
    $tpl->assign("icon_url", $article_info['icon_url']);
    $tpl->assign("content", $article_info['content']);

    $tpl->assign("content_title", "编辑文章 - <b>" . $doctor_info['name'] . "</b>");
    $tpl->assign("new_one", 0);

    $tpl->display("doctor_article.html");
    exit;
  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
  do {
    $user = $_SESSION['user']['user'];

    $article_id = $_POST['id'];
    $doctor_id = $_POST['doctor_id'];
    $article_type = (int)$_POST['article_type'];
    $topic = $_POST['topic'];
    $content = $_POST['editorValue'];

    if (strlen($topic) > 90
        || ($article_type < 1 || $article_type > 4)
        || strlen($content) > 12000) {
      $err_msg = "标题或内容太长";
      break;
    }

    if (get_magic_quotes_gpc()) {
      $topic = stripslashes($topic);
      $content = stripslashes($content);
    }

    $article_info = tb_doctor_article::query_article_by_id($article_id);
    if ($article_info === false || empty($article_info)) {
      $err_msg = "查找该文章失败";
      break;
    }

    if ((int)$doctor_id !== (int)$article_info['doctor_id']) {
      $err_msg = "参数不匹配";
      break;
    }
    $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
    if ($doctor_info === false || empty($doctor_info)) {
      $err_msg = "查找该医生失败";
      break;
    }

    //upload file
    $err_msg = '';
    $filename = '';
    $icon_url = '';
    $photo = 'icon';
    if (!empty($_FILES[$photo]["name"])) {
      $filename = $_FILES[$photo]["name"];
      if ($_FILES[$photo]["error"] > 0) {
        $err_msg = 'Return Code: ' . $_FILES[$photo]["error"];
        break;
      }
      if ($_FILES[$photo]["size"] > 2*1024*1024) {
        $err_msg = $filename . " 图片大小超出限制(2M)";
        break;
      }
      if (!check::can_upload($_FILES[$photo]['type'])) {
        $err_msg = "图片格式不支持";
        break;
      }
      $mime = explode('/', $_FILES[$photo]['type']);
      $ext = $mime[1];
      $basename = md5($topic . "doctor_article_icon" . time());

      $filename = $basename . "." . $ext;
      $path = MNG_ROOT . 'image/';

      $filename = $basename . "." . $ext;
      $path = MNG_ROOT . 'image/';

      move_uploaded_file($_FILES[$photo]['tmp_name'], $path . $filename);

      $icon_url = BASE_URL . "image/$filename";
    }
    if ($err_msg != '') {
      break;
    }
    // upload end

    $update_info = array();
    if (!empty($article_type)) {
      $update_info['article_type'] = $article_type;
    }
    if (!empty($topic)) {
      $update_info['topic'] = $topic;
    }
    if (!empty($icon_url)) {
      $update_info['icon_url'] = $icon_url;
    }
    if (!empty($content)) {
      $update_info['content'] = $content;
    }
    tb_doctor_article::update($article_id, $doctor_id, $update_info);

    $err_msg = "编辑成功";
    alert_and_redirect($err_msg, "view/doctor_article_view.php?id={$article_id}&doctor_id={$doctor_id}");
  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
}
