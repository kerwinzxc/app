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
  if ($act == 'zan') {
    if ($tb_ba_topic_zan::user_had_zan($topic_id, $user_id)) {
      $ret_code = ERR_BA_TOPIC_HAD_ZAN;
      break;
    }
    if (tb_ba_topic_zan::insert_new_one($topic_id, $user_id) === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
    tb_ba_topic::incr_zan_counter($topic_id);
  } elseif ($act == 'cancel') {
    if ($tb_ba_topic_zan::user_had_zan($topic_id, $user_id) === false) {
      $ret_code = ERR_BA_TOPIC_HAD_NOT_ZAN;
      break;
    }
    if (tb_ba_topic_zan::del_one($topic_id, $user_id) === false) {
      tb_ba_topic::decr_zan_counter($topic_id);
    }
  } else {
    $ret_code = ERR_PARAM_INVALID;
  }
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
