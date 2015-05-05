<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';

require_once MNG_ROOT . 'autoload.php'; // below smarty
require_once MNG_ROOT . '../common/cc_key_def.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] != "GET") exit;

do {
  if (empty($_GET['opt'])
      || empty($_GET['id'])) {
    $err_msg = "参数错误";
    break;
  }

  $opt = $_GET['opt'];
  $id = $_GET['id'];

  $ba_info = tb_ba::query_ba_by_id($id);
  if ($ba_info === false) {
    $err_msg = '访问数据库失败';
    break;
  } else if (empty($ba_info)) {
    $err_msg = '查无此吧';
    break;
  } else {
    $update_info = array();
    if ($opt == 'open'
        && $ba_info['open'] == '0') {
      $update_info['open'] = 1;
    } else {
      if ($opt == 'close'
          && $ba_info['open'] == '1') {
        $update_info['open'] = 0;
      }
    }
    if (!empty($update_info)) {
      if (tb_ba::update($id, $update_info) !== false) {
        $err_msg = "修改成功";
      } else {
        $err_msg = '系统内部错误，修改失败';
      }
    }
  }
} while (false);
alert_and_redirect($err_msg, $_SERVER['HTTP_REFERER']);
