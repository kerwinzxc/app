<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty
require_once MNG_ROOT . '../common/cc_key_def.php'; // below smarty

$err_msg = '';

$tpl->assign("content_title", "病友吧信息");
$tpl->assign("new_one", 0);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $name = trim($_POST['name']);
  $desc = trim($_POST['desc']);
  $id = $_POST['id'];

  do {
    if (empty($id)
        || empty($name) || strlen($name) > 27 || strlen($name) < 6
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

    $icon_url = '';
    if (!empty($_FILES['icon']["name"])) {
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
    }

    $update_info = array();
    if (!empty($priority)) {
      $update_info['priority'] = $priority;
    }
    if (!empty($name)) {
      $update_info['name'] = $name;
    }
    if (!empty($desc)) {
      $update_info['ba_desc'] = $desc;
    }
    if (!empty($icon_url)) {
      $update_info['icon_url'] = $icon_url;
    }

    if (tb_ba::update($id, $update_info) !== false) {
      for ($i = 1; $i <= 5; $i++) {
        if (!empty($_POST['doctor' . $i])) {
          $doctor_id = trim($_POST['doctor' . $i]);
          $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
          if ($doctor_info === false || empty($doctor_info)) {
            $err_msg = "查找该医生失败";
            break;
          }
          if (tb_ba_rel_doctor::update($id, $doctor_id) === false) {
            $err_msg = "保存数据库失败";
            break;
          }
        }
      }
      if (empty($err_msg)) {
        $err_msg = '编辑成功';
      }
    } else {
      $err_msg = '系统内部错误，编辑失败';
    }
  } while (false);
  build_html($id);
  alert($err_msg);
} else {
  if (empty($_GET['id'])) {
    $err_msg = "query failed";
  } else {
    $id = $_GET['id'];
    build_html($id);
  }
}

function build_html($id)
{
  global $tpl;
  $ba_info = tb_ba::query_ba_by_id($id);
  if ($ba_info === false || empty($ba_info)) {
    $err_msg = "query failed";
  } else {
    $tpl->assign("id", $id);
    $tpl->assign("priority", $ba_info['priority']);
    $tpl->assign("name", $ba_info['name']);
    $tpl->assign("desc", $ba_info['ba_desc']);
    $tpl->assign("icon_url", $ba_info['icon_url']);

    $ret = tb_ba_rel_doctor::query_ba_rel_doctor_list($id);
    if (!empty($ret)) {
      $ret = array_map(function ($r) { return (int)$r['doctor_id'];}, $ret);
    }
    $tpl->assign("rel_doctors", empty($ret) ? array() : $ret);
  }
}

$tpl->assign("refer", $_SERVER['HTTP_REFERER']);
$tpl->assign("err_msg", $err_msg);
$tpl->assign("inc_name", "bing_you_ba.html");
$tpl->display("home.html");
