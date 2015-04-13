<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once ROOT . 'init.php';
require_once ROOT . 'view/fill_menu_name.inc.php';
require_once ROOT . 'libs/crm_db.inc.php';
require_once ROOT . 'libs/func.inc.php';

function class_loader($cls)
{
  $file = ROOT . '/../class/' . $cls . '.class.php';
  require_once($file);
}
spl_autoload_register('class_loader');

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $tpl->assign("content_title", S_DOCTOR_LU_RU);
  $tpl->assign("doctor_info_title", S_DOCTOR_XIN_XI);
  $tpl->assign("new_one", 1);
  $tpl->assign("inc_name", "doctor_info.html");

  $tpl->display("home.html");
}else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $err_msg = '';
  $name = $_POST['name'];
  $sex = $_POST['sex'];
  $phone_num = $_POST['phone_num'];
  $classify = $_POST['classify'];
  $hospital = $_POST['hospital'];
  $expert_in = $_POST['expert_in'];
  $tec_title = $_POST['tec_title'];
  $aca_title = $_POST['aca_title'];

  do {
    if (empty($name) || !check::is_name($name)
        || !isset($sex) || !check::is_sex($sex)
        || empty($phone_num) || !check::is_phone_num($phone_num)
        || !check::is_doctor_classify($classify)
        || empty($hospital) || strlen($hospital) > 90
        || empty($expert_in) || strlen($expert_in) > 300
        || empty($tec_title) || !is_numeric($tec_title)
        || empty($aca_title) || !is_numeric($aca_title)) {
      $err_msg = '输入参数错误';
      break;
    }

    if (get_magic_quotes_gpc()) {
      $name = stripslashes($name);
      $hospital = stripslashes($hospital);
      $expert_in = stripslashes($expert_in);
    }
    $user = $_SESSION['user']['user'];

    $doctor_info = tb_doctor::query_doctor_by_phone_num($phone_num);
    if (!empty($doctor_info)) {
      $err_msg = '该医生已经录入！';
      break;
    }

    //upload file
    $err_msg = '';
    $photos = array('photo' => '');
    foreach ($photos as $photo => $fn) {
      $filename = $_FILES[$photo]["name"];
      if (empty($filename)) continue;
      if ($_FILES[$photo]["error"] > 0) {
        $err_msg = 'Return Code: ' . $_FILES[$photo]["error"];
        break;
      }
      if ($_FILES[$photo]["size"] > 2*1024*1024) {
        $err_msg = $filename . " 图片大小超出限制(2M)";
        break;
      }
      $filename = md5($name . $phone_num . "doctor_icon")
        . "."
        . util::get_file_ext($filename);
      move_uploaded_file($_FILES[$photo]['tmp_name'], ROOT . 'image/' . $filename);
      $photos[$photo] = $filename;
    }
    if ($err_msg != '') {
      break;
    }
    // upload end

    $new_doctor_id = tb_doctor::insert_new_one($phone_num,
        md5('000000'),
        $name,
        $sex,
        BASE_URL . "image/{$filename}",
        $tec_title,
        $aca_title,
        $hospital,
        $expert_in,
        time());
    if ($new_doctor_id != false) {
      $err_msg = '录入成功';
    } else {
      $err_msg = '系统内部错误，录入失败';
    }

  } while (false);
  alert_and_redirect($err_msg, 'view/doctor_entering.php');
}
