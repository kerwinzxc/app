<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_POST['content'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $content = htmlspecialchars($_POST['content']);
  if (strlen($content) > 450) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  if (get_magic_quotes_gpc()) {
    $content = stripslashes($content);
  }
  $user_id = 0;
  if (!empty($_GET['sid'])) {
    $sid = $_GET['sid'];
    $s_info = user_session::get_session($sid);
    if (!empty($s_info)) {
      $s_info = json_decode($s_info, true);
      if (!empty($s_info)) {
        $user_id = $s_info['user_id'];
      }
    }
  }

  tb_feedback::insert_new_one($user_id, $content, time());
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
