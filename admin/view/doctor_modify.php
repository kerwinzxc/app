<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty
require_once MNG_ROOT . '../common/cc_key_def.php'; // below smarty

$err_msg = '';
$recent_jh_num = 0;

$tpl->assign("content_title", S_DOCTOR_XIN_XI);
$tpl->assign("doctor_info_title", S_DOCTOR_XIN_XI);
$tpl->assign("show_recent_jh", 1);
$tpl->assign("new_one", 0);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $doctor_id = $_POST['id'];
  $name = trim($_POST['name']);
  $sex = $_POST['sex'];
  $phone_num = $_POST['phone_num'];
  $classify = $_POST['classify'];
  $ke_shi = $_POST['ke_shi'];
  $hospital = trim($_POST['hospital']);
  $expert_in = $_POST['expert_in'];
  $tec_title = $_POST['tec_title'];
  $aca_title = isset($_POST['aca_title']) ? (int)$_POST['aca_title'] : 0;
  $adm_title = $_POST['adm_title'];

  do {
    if (empty($name) || !check::is_name($name)
        || empty($doctor_id) || $doctor_id <= 0
        || !isset($sex) || !check::is_sex($sex)
        || empty($phone_num) || !check::is_phone_num($phone_num)
        || !check::is_doctor_classify($classify)
        || empty($hospital) || strlen($hospital) > 90
        || empty($expert_in) || strlen($expert_in) > 450
        || empty($ke_shi) || !is_numeric($ke_shi)
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

    tb_doctor::query_doctor_by_phone_num($phone_num);
    if (!empty($doctor_info)) {
      $err_msg = '该电话已经录入！';
      break;
    }
    $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
    if (empty($doctor_info)) {
      $err_msg = '该医生未录入！';
      break;
    }
    if ($doctor_info['employe_id'] != $user) {
      $err_msg = '您没有权限编辑';
      break;
    }

    //upload file
    $err_msg = '';
    $filename = '';
    $photo = 'photo';
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
      $filename = md5($phone_num . "doctor_icon")
        . "."
        . $mime[1];

      move_uploaded_file($_FILES[$photo]['tmp_name'], MNG_ROOT . 'image/' . $filename);
    }
    if ($err_msg != '') {
      break;
    }
    // upload end

    $update_info = array();
    if (!empty($name)) {
      $update_info['name'] = $name;
    }
    if (!empty($phone_num)) {
      $update_info['phone_num'] = $phone_num;
    }
    if (!empty($classify)) {
      $update_info['classify'] = $classify;
    }
    $update_info['sex'] = $sex;
    if (!empty($filename)) {
      $update_info['icon_url'] = $filename;
    }
    if (!empty($ke_shi)) {
      $update_info['ke_shi'] = $ke_shi;
    }
    if (!empty($tec_title)) {
      $update_info['tec_title'] = $tec_title;
    }
    if (!empty($aca_title)) {
      $update_info['aca_title'] = $aca_title;
    }
    if (isset($adm_title)) {
      $update_info['adm_title'] = $adm_title;
    }
    if (!empty($hospital)) {
      $update_info['hospital'] = $hospital;
    }
    if (!empty($gexpert_in)) {
      $update_info['gexpert_in'] = $gexpert_in;
    }

    if (tb_doctor::update($doctor_id, $update_info) !== false) {
      $err_msg = '编辑成功';
    } else {
      $err_msg = '系统内部错误，编辑失败';
    }
  } while (false);
  build_html($doctor_id);
  alert($err_msg);
} else {
  if (empty($_GET['id'])) {
    $err_msg = "query failed";
  } else {
    $doctor_id = $_GET['id'];
    $tpl->assign("refer", $_SERVER['HTTP_REFERER']);
    build_html($doctor_id);
  }
}

function build_html($doctor_id)
{
  global $tpl;
  global $recent_jh_num;
  $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
  if ($doctor_info === false || empty($doctor_info)) {
    $err_msg = "query failed";
  } else {
    $tpl->assign("id", $doctor_id);
    $tpl->assign("name", $doctor_info['name']);
    $tpl->assign("phone_num", $doctor_info['phone_num']);
    $tpl->assign("classify", $doctor_info['classify']);
    $tpl->assign("sex", $doctor_info['sex']);

    $icon_url = $doctor_info['icon_url'];
    $icon_url = empty($icon_url) ? '' : BASE_URL . "image/{$icon_url}";
    $tpl->assign("icon_url", $icon_url);

    $tpl->assign("ke_shi", $doctor_info['ke_shi']);
    $tpl->assign("tec_title", $doctor_info['tec_title']);
    $tpl->assign("aca_title", $doctor_info['aca_title']);
    $tpl->assign("adm_title", $doctor_info['adm_title']);
    $tpl->assign("hospital", $doctor_info['hospital']);
    $tpl->assign("expert_in", $doctor_info['expert_in']);
    $tpl->assign("c_time", $doctor_info['c_time']);
    $recent_jh_num = 1;
  }
}

$tpl->assign("err_msg", $err_msg);
$tpl->assign("recent_jh_num", $recent_jh_num);
$tpl->assign("inc_name", "doctor_info.html");
$tpl->display("home.html");
