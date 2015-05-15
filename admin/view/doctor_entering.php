<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  if (!empty($_GET['master_id'])) {
    $doctor_info = tb_doctor::query_doctor_by_id($_GET['master_id']);
    if (empty($doctor_info)
        || $doctor_info['classify'] != '2') {
      $err_msg = '不能填加助手';
      alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
    }
    $tpl->assign("master_id", $_GET['master_id']);
    $tpl->assign("master_name", $doctor_info['name']);
    $tpl->assign("content_title", "医生录入");
  } else {
    $tpl->assign("content_title", S_DOCTOR_LU_RU);
  }

  $ret = tb_disease::query_all();
  $tpl->assign('disease_rows', $ret === false ? array() : $ret);

  $tpl->assign("refer", '');
  $tpl->assign("doctor_info_title", S_DOCTOR_XIN_XI);
  $tpl->assign("new_one", 1);
  $tpl->assign("inc_name", "doctor_info.html");

  $tpl->display("home.html");
}else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $err_msg = '';
  $name = trim($_POST['name']);
  $sex = $_POST['sex'];
  $phone_num = $_POST['phone_num'];
  $master_id = 0;
  if (!empty($_POST['master_id'])) {
    $master_id = $_POST['master_id'];
  }
  $classify = $_POST['classify'];
  $disease_id = $_POST['disease'];
  $ke_shi = $_POST['ke_shi'];
  $hospital = trim($_POST['hospital']);
  $expert_in = $_POST['expert_in'];
  $tec_title = $_POST['tec_title'];
  $aca_title = $_POST['aca_title'];
  $adm_title = isset($_POST['aca_title']) ? (int)$_POST['adm_title'] : 0;

  do {
    if (empty($name) || !check::is_name($name)
        || !isset($sex) || !check::is_sex($sex)
        || empty($phone_num) || !check::is_phone_num($phone_num)
        || !check::is_doctor_classify($classify)
        || empty($hospital) || strlen($hospital) > 90
        || empty($expert_in) || strlen($expert_in) > 450
        || empty($ke_shi) || !is_numeric($ke_shi)
        || !is_numeric($disease_id)
        || empty($tec_title) || !is_numeric($tec_title)
        || empty($aca_title) || !is_numeric($aca_title)) {
      $err_msg = '输入参数错误';
      break;
    }

    if (empty(tb_disease::query_disease_by_id($disease_id))) {
      $err_msg = '咨询室病种ID无效';
      break;
    }

    if (get_magic_quotes_gpc()) {
      $name = stripslashes($name);
      $hospital = stripslashes($hospital);
      $expert_in = stripslashes($expert_in);
    }

    $disease_list = array("disease1", "disease2", "disease3", "disease4");
    $rel_disease_list = array($disease_id);
    foreach ($disease_list as $dis) {
      if (!empty($_POST[$dis])) {
        $id = (int)$_POST[$dis];
        if (!empty(tb_disease::query_disease_by_id($id))) {
          if (!in_array($id, $rel_disease_list))
            $rel_disease_list[] = $id;
        }
      }
    }

    $user = $_SESSION['user']['user'];

    $doctor_info = tb_doctor::query_doctor_by_phone_num($phone_num);
    if (!empty($doctor_info)) {
      $err_msg = '该医生已经录入！';
      break;
    }

    //upload file
    $path = "image/doctor/icon/" . date("Ymd");
    $up = new upload($_FILES['photo'],
                     IMG_ROOT . "/" . $path,
                     2*1024*1024,
                     array('.jpg', '.jpeg', '.png')
                    );
    if ($up->just_do_it() === false) {
      $err_msg = $up->error();
      break;
    }
    $icon_url = IMG_BASE_URL . $path . "/" . $up->filename();

    $new_doctor_id = tb_doctor::insert_new_one($phone_num,
                                               md5('000000'),
                                               $user,
                                               $master_id,
                                               $disease_id,
                                               $classify,
                                               $name,
                                               $sex,
                                               $icon_url,
                                               $ke_shi,
                                               $tec_title,
                                               $aca_title,
                                               $adm_title,
                                               $hospital,
                                               $expert_in,
                                               time());
    if ($new_doctor_id != false) {
      foreach ($rel_disease_list as $dis) {
        tb_disease_rel_doctor::update($dis, $new_doctor_id);
      }
      $err_msg = '录入成功';
    } else {
      $err_msg = '系统内部错误，录入失败';
    }

  } while (false);
  alert_and_redirect($err_msg, 'view/doctor_entering.php');
}
