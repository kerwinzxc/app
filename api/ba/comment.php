<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['sid'])
      || empty($_GET['topic_id'])
      || empty($_GET['do'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_GET['sid'];
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

  $topic_id = (int)$_GET['topic_id'];
  if ($topic_id <= 0) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $act = $_GET['do'];
  if ($act == 'useful') {
    $ret = tb_ba_topic::incr_useful_counter($topic_id);
  } elseif ($act == 'useless') {
    $ret = tb_ba_topic::incr_useless_counter($topic_id);
  } else {
    $ret_code = ERR_PARAM_INVALID;
  }
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
