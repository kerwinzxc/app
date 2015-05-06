<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  do {
    if (empty($_GET['doctor_id'])) {
      $err_msg = "参数错误";
      break;
    }

    $doctor_id = $_GET['doctor_id'];
    $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
    if ($doctor_info === false || empty($doctor_info)) {
      $err_msg = "查找该医生失败";
      break;
    }

    $ret = tb_ba_rel_doctor::query_doctor_rel_ba($doctor_id);
    $ba_list = tb_ba::query_ba_all_open_list();
    if ($ret === false
        || $ba_list === false) {
      $err_msg = "读取数据库失败";
      break;
    }

    $tpl->assign("ba_id", empty($ret) ? '' : $ret['ba_id']);
    $tpl->assign("ba_rows", $ba_list);

    $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
    $tpl->assign("doctor_id", $doctor_id);
    $tpl->assign("content_title", "关联病友吧 - <b>" . $doctor_info['name'] . "</b>");
    $tpl->assign("inc_name", "relation_ba.html");

    $tpl->display("home.html");
    exit;
  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
} else {
  if (empty($_POST['doctor_id'])
      || empty($_POST['ba'])) {
    $err_msg = "参数错误";
    break;
  }

  $doctor_id = $_POST['doctor_id'];
  $ba_id = $_POST['ba'];
  $ret = tb_ba::query_ba_by_id($ba_id);
  if (empty($ret)) {
    $err_msg = "选择的病友吧不存在";
    break;
  }
  $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
  if ($doctor_info === false || empty($doctor_info)) {
    $err_msg = "查找该医生失败";
    break;
  }
  if (tb_ba_rel_doctor::update($ba_id, $doctor_id) === false) {
    $err_msg = "保存数据库失败";
    break;
  }
  $err_msg = "关联成功";
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
}
