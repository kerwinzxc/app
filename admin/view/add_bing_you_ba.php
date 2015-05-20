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

    if (tb_ba::query_ba_name_exist_or_not($name)) {
      $err_msg = "吧名已经存在，请更换";
      break;
    }

    $path = "image/ba/icon";
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

    $new_ba_id = tb_ba::insert_new_one($priority, $name, $desc, $icon_url);
    if ($new_ba_id != false) {
      for ($i = 1; $i <= 5; $i++) {
        if (!empty($_POST['doctor' . $i])) {
          $doctor_id = trim($_POST['doctor' . $i]);
          $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
          if ($doctor_info === false || empty($doctor_info)) {
            $err_msg = "查找该医生失败";
            break;
          }
          if (tb_ba_rel_doctor::update($new_ba_id, $doctor_id) === false) {
            $err_msg = "保存数据库失败";
            break;
          }
        }
      }
      if (empty($err_msg)) {
        $err_msg = '添加成功';
      }
      // end
    } else {
      $err_msg = '系统内部错误，添加失败';
    }
  } while (false);
  alert_and_redirect($err_msg, 'view/add_bing_you_ba.php');
}
