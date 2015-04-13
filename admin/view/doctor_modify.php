<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once ROOT . 'init.php';
require_once ROOT . 'view/fill_menu_name.inc.php';
require_once ROOT . 'autoload.php'; // below smarty

$err_msg = '';
$recent_jh_num = 0;

$tpl->assign("content_title", S_HUO_CHE_XIN_XI);
$tpl->assign("che_info_title", S_HUO_CHE_XIN_XI);
$tpl->assign("show_recent_jh", 1);
$tpl->assign("new_one", 0);

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  echo $_POST['uid'];
  exit;
}else
{
  if (empty($_GET['uid']))
    $err_msg = "query failed";
  else
  {
    $rows = crm_db::query_truck_by_uid($_GET['uid']);
    if (!$rows || count($rows) == 0)
      $err_msg = "query failed";
    else
    {
      $tpl->assign("uid", $_GET['uid']);
      $tpl->assign("name", $rows[0]['name']);
      $tpl->assign("id_card", $rows[0]['id_card']);
      $tpl->assign("phone_num", $rows[0]['phone_num']);
      $tpl->assign("truck_id", $rows[0]['truck_id']);
      $tpl->assign("classify", $rows[0]['classify']);
      $tpl->assign("length", $rows[0]['length']);
      $tpl->assign("payload", $rows[0]['payload']);
      $tpl->assign("truck_zm_photo", empty($rows[0]['truck_zm_photo']) ? '' : "image/" . $rows[0]['truck_zm_photo']);
      $tpl->assign("truck_cm_photo", empty($rows[0]['truck_cm_photo']) ? '' : "image/" . $rows[0]['truck_cm_photo']);
      $tpl->assign("jsz_photo", empty($rows[0]['jsz_photo']) ? '' : "image/" . $rows[0]['jsz_photo']);
      $tpl->assign("xsz_photo", empty($rows[0]['xsz_photo']) ? '' : "image/" . $rows[0]['xsz_photo']);
      $tpl->assign("cyzgz_photo", empty($rows[0]['cyzgz_photo']) ? '' : "image/" . $rows[0]['cyzgz_photo']);
      $tpl->assign("dangerous_cyzgz_photo", empty($rows[0]['dangerous_cyzgz_photo']) ? '' : "image/" . $rows[0]['dangerous_cyzgz_photo']);
      $recent_jh_num = 1;
    }
  }
}

$tpl->assign("err_msg", $err_msg);
$tpl->assign("recent_jh_num", $recent_jh_num);
$tpl->assign("inc_name", "che_info.html");
$tpl->display("home.html");
