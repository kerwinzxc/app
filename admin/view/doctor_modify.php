<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty
require_once MNG_ROOT . '../common/cc_key_def.php'; // below smarty

$err_msg = '';
$recent_jh_num = 0;

$tpl->assign("content_title", S_DOCTOR_XIN_XI);
$tpl->assign("doctor_info_title", S_DOCTOR_XIN_XI);
$tpl->assign("show_recent_jh", 1);
$tpl->assign("new_one", 0);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  echo $_POST['id'];
  exit;
} else {
  if (empty($_GET['id'])) {
    $err_msg = "query failed";
  } else {
    $doctor_id = $_GET['id'];
    $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
    if (!$doctor_info || count($doctor_info) == 0) {
      $err_msg = "query failed";
    } else {
      $tpl->assign("id", $doctor_id);
      $tpl->assign("name", $doctor_info['name']);
      $tpl->assign("phone_num", $doctor_info['phone_num']);
      $tpl->assign("classify", $doctor_info['classify']);
      $tpl->assign("sex", $doctor_info['sex']);
      $tpl->assign("icon_url", $doctor_info['icon_url']);
      $tpl->assign("ke_shi", $doctor_info['ke_shi']);
      $tpl->assign("tec_title", $doctor_info['tec_title']);
      $tpl->assign("aca_title", $doctor_info['aca_title']);
      $tpl->assign("hospital", $doctor_info['hospital']);
      $tpl->assign("expert_in", $doctor_info['expert_in']);
      $recent_jh_num = 1;
    }
  }
}

$tpl->assign("err_msg", $err_msg);
$tpl->assign("recent_jh_num", $recent_jh_num);
$tpl->assign("inc_name", "doctor_info.html");
$tpl->display("home.html");
