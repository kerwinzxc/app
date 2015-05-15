<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $tpl->assign("content_title", "添加专家文章推广图");
  $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
  $tpl->assign("new_one", 1);
  $tpl->assign("inc_name", "article_banner.html");

  $tpl->display("home.html");
}else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $err_msg = '';

  do {
    $priority = 0;
    if (!empty($_POST['priority'])) {
      $priority = (int)$_POST['priority'];
    }
    if ($priority < 1) $priority = 1;
    if ($priority > 10000) $priority = 10000;

    $articel_id = 0;
    if (!empty($_POST['article_id'])) {
      $article_id = (int)$_POST['article_id'];
      $article_info = tb_doctor_article::query_article_by_id($article_id);
      if (empty($article_info)) {
        $err_msg = '文章ID无效';
        break;
      }
    }

    $user = $_SESSION['user']['user'];

    $path = "image/article/banner";
    $up = new upload($_FILES['image'],
                     IMG_ROOT . "/" . $path,
                     2*1024*1024,
                     array('.jpg', '.jpeg', '.png')
                    );
    if ($up->just_do_it() === false) {
      $err_msg = $up->error();
      break;
    }
    $img_url = IMG_BASE_URL . $path . "/" . $up->filename();

    $target = '';
    if ($article_id !== 0) {
      $target = json_encode(array("article_id" => $article_id));
    }
    $new_banner_id = tb_article_banner::insert_new_one($priority, $img_url, $target);
    if ($new_banner_id !== false) {
      $err_msg = '添加成功';
    } else {
      $err_msg = '系统内部错误，添加失败';
    }
  } while (false);
  alert_and_redirect($err_msg, 'view/add_article_banner.php');
}
