<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;

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

  $path = "image/u/icon/" . date("Ymd");
  $up = new upload($_FILES['head_icon'],
                   IMG_ROOT . "/" . $path,
                   2*1024*1024,
                   array('jpg', 'jpeg', 'png')
                   );
  if ($up->just_do_it() === false) {
    $ret_code = ERR_UPLOAD_ICON_ERROR;
    ilog::error($up->error());
    break;
  }
  $icon_url = IMG_BASE_URL . $path . "/" . $up->filename();
  if (tb_user::set_icon_url($user_id, $icon_url) === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }

  $ret_body['icon_url'] = $icon_url;
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
