<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty
require_once MNG_ROOT . '../common/cc_key_def.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

do {
  if (empty($_GET['id'])) {
    $err_msg = "参数错误";
    break;
  }

  $topic_id = $_GET['id'];
  $topic_info = tb_ba_topic::query_topic_by_id($topic_id);
  if ($topic_info === false || empty($topic_info)) {
    $err_msg = "查找该话题失败";
    break;
  }

  if (tb_ba_topic_comment::del_commens_by_topic_id($topic_id) === false) {
    $err_msg = "数据库操作错误";
    break;
  }
  if (tb_ba_topic::del_one($topic_id) === false) {
    $ret_code = "数据库操作错误";
    break;
  }

} while (false);
alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
