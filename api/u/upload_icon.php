<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;

define('USER_ICON_PATH', 'image/u/icon');

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_POST['sid'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $sid = $_POST['sid'];
  $s_info = user_session::get_session($sid);
  if ($s_info === false) {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }

  $s_info = json_decode($s_info, true);
  if (empty($s_info)) {
    $ret_code = ERR_NOT_LOGIN;
    break;
  }
  $user_id = $s_info['user_id'];

  $filename = '';
  $icon_url = '';
  $photo = 'head_icon';
  if (!empty($_FILES[$photo]["name"])) {
    $filename = $_FILES[$photo]["name"];
    if ($_FILES[$photo]["error"] > 0) {
      $ret_code = ERR_UPLOAD_ICON_ERROR;
      break;
    }
    if ($_FILES[$photo]["size"] > 2*1024*1024) {
      $ret_code = ERR_UPLOAD_ICON_SIZE_LIMIT;
      break;
    }
    if (!check::can_upload($_FILES[$photo]['type'])) {
      $ret_code = ERR_UPLOAD_ICON_TYPE_INVALID;
      break;
    }
    $mime = explode('/', $_FILES[$photo]['type']);
    $ext = $mime[1];
    $basename = md5($user_id . "ddky_user_icon" . time());

    $path = USER_ICON_PATH . "/" . date("Ymd");
    $disk_path = APP_ROOT . "/" . $path;
    if (!file_exists($disk_path)) {
      if (!mkdir($disk_path)) {
        $ret_code = ERR_UPLOAD_ICON_DISK_ERROR;
        break;
      }
    }
    $filename = $basename . "." . $ext;
    $mv_ret = move_uploaded_file($_FILES[$photo]['tmp_name'],
                                 $disk_path . "/" . $filename);
    $icon_url = APP_BASE_URL . $path . "/" . $filename;
    if ($mv_ret === false
        || tb_user::set_icon_url($user_id, $icon_url) === false) {
      $ret_code = ERR_UPLOAD_ICON_MV_FAILED;
      break;
    }
  } else {
    $ret_code = ERR_INNER_ERROR;
    break;
  }
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
