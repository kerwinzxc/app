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
    $tpl->assign("topic", htmlspecialchars_decode($article_info['topic']));
    $tpl->assign("article_type", $article_info['article_type']);
    $tpl->assign("icon_url", $article_info['icon_url']);
    $tpl->assign("content", htmlspecialchars_decode($article_info['content']));

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
    $topic = htmlspecialchars($_POST['topic']);
    $content = htmlspecialchars($_POST['editorValue']);

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

    $icon_url = '';
    if (!empty($_FILES['icon']["name"])) {
      $path = "image/article/icon";
      $up = new upload($_FILES['icon'],
                       IMG_ROOT . "/" . $path,
                       2*1024*1024,
                       array('.jpg', '.jpeg', '.png')
                      );
      if ($up->just_do_it() === false) {
        $err_msg = $up->error();
        break;
      }
      $icon_url = IMG_BASE_URL . $path . "/" . $up->filename();
    }

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
