<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $tpl->assign("content_title", "添加病友吧");
  $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
  $tpl->assign("new_one", 1);
  $tpl->assign("inc_name", "bing_you_ba.html");

  $tpl->display("home.html");
}else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $err_msg = '';
  $name = trim($_POST['name']);
  $desc = trim($_POST['desc']);

  do {
    if (empty($name) || strlen($name) > 27 || strlen($name) < 6
        || empty($desc) || strlen($desc) > 90 || strlen($desc) < 9) {
      $err_msg = '输入参数错误';
      break;
    }
    $priority = 0;
    if (!empty($_POST['priority'])) {
      $priority = (int)$_POST['priority'];
    }
    if ($priority < 1) $priority = 1;
    if ($priority > 10000) $priority = 10000;

    if (get_magic_quotes_gpc()) {
      $name = stripslashes($name);
      $desc = stripslashes($desc);
    }
    $user = $_SESSION['user']['user'];

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
      $basename = md5($name . "ddky_bing_you_ba_icon" . time());

      $filename = $basename . "." . $ext;
      $path = MNG_ROOT . 'image/';

      move_uploaded_file($_FILES[$photo]['tmp_name'], $path . $filename);

      $icon_url = BASE_URL . "image/$filename";
    }
    if ($err_msg != '') {
      break;
    }
    // upload end

    $new_ba_id = tb_ba::insert_new_one($priority, $name, $desc, $icon_url);
    if ($new_ba_id != false) {
      $err_msg = '添加成功';
    } else {
      $err_msg = '系统内部错误，添加失败';
    }
  } while (false);
  alert_and_redirect($err_msg, 'view/add_bing_you_ba.php');
}
