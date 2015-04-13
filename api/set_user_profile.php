<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;

$ret_code = 0;
$result = array();

do {
  if (empty($_POST['sid'])
      || empty($_POST['name'])
      || empty($_POST['id_card'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_POST['sid'];
  $name = $_POST['name'];
  $id_card = $_POST['id_card'];

  if (!user_session::is_sid($sid)
      || !check::is_id_card($id_card)
      || !check::is_name($name)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  if (get_magic_quotes_gpc()) {
    $name = stripslashes($name);
  }

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

  if (tb_user::query_user_id_card_exist_or_not($id_card)) {
    $ret_code = ERR_ID_CARD_INVALID;
    break;
  }
  if (tb_user::set_profile($user_id, $name, $id_card) === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $ret_body['name'] = $user_info['name'];

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
