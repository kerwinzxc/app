<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

$err_msg = '';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  do {
    if (empty($_GET['doctor_id'])
        || empty($_GET['ba_id'])) {
      $err_msg = "参数错误";
      break;
    }

    $doctor_id = $_GET['doctor_id'];
    $ba_id = $_GET['ba_id'];
    $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
    if ($doctor_info === false || empty($doctor_info)) {
      $err_msg = "查找该医生失败";
      break;
    }

    tb_ba_rel_doctor::del_one($ba_id, $doctor_id);

  } while (false);
  alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
}
