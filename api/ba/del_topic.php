<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_POST['sid'])
      || empty($_POST['topic_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_POST['sid'];
  $topic_id = (int)$_POST['topic_id'];
  if (!user_session::is_sid($sid)
      || $topic_id <= 0) {
    $ret_code = ERR_PARAM_INVALID;
    break;
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

  $topic_info = tb_ba_topic::query_topic_by_id($topic_id);
  if ($topic_info === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  if (empty($topic_info)) {
    $ret_code = ERR_BA_TOPIC_NOT_EXIST;
    break;
  }
  if ($topic_info['user_id'] != $user_id) {
    $ret_code = ERR_DEL_TOPIC_DENY;
    break;
  }
  if (tb_ba_topic_comment::del_commens_by_topic_id($topic_id) === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  if (tb_ba_topic::del_one($topic_id) === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
