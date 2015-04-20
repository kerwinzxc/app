<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_POST['sid'])
      || empty($_POST['ba_id'])
      || empty($_POST['topic'])
      || empty($_POST['content'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_POST['sid'];
  $ba_id = (int)$_POST['ba_id'];
  $topic = $_POST['topic'];
  $content = $_POST['content'];
  if (!user_session::is_sid($sid)
      || $ba_id <= 0
      || strlen($topic > 90)
      || strlen($content) > 12000) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  if (get_magic_quotes_gpc()) {
    $topic = stripslashes($topic);
    $content = stripslashes($content);
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

  $new_topic_id = tb_ba_topic::insert_new_one($ba_id,
                                              $user_id,
                                              $topic,
                                              time());
  if ($new_topic_id === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  if (tb_ba_topic_reply::insert_new_one($new_topic_id,
                                        $user_id,
                                        $user_id,
                                        $content,
                                        time()) === false) {
    tb_ba_topic::del_one($new_topic_id);
    $ret_code = ERR_DB_ERROR;
    break;
  }

  $ret_body['topic_id'] = $new_topic_id;

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
