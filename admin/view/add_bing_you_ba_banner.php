<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $tpl->assign("content_title", "添加病友吧推广图");
  $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
  $tpl->assign("new_one", 1);
  $tpl->assign("inc_name", "bing_you_ba_banner.html");

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

    $user = $_SESSION['user']['user'];

    $path = "image/ba/banner";
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

    $new_ba_banner_id = tb_ba_banner::insert_new_one($priority, $img_url, "");
    if ($new_ba_banner_id != false) {
      $err_msg = '添加成功';
    } else {
      $err_msg = '系统内部错误，添加失败';
    }
  } while (false);
  alert_and_redirect($err_msg, 'view/add_bing_you_ba_banner.php');
}
