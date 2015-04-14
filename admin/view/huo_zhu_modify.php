<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/crm_db.inc.php';

$err_msg = '';
$recent_fh_num = 0;

$tpl->assign("content_title", S_HUO_ZHU_XIN_XI);
$tpl->assign("huo_zhu_info_title", S_HUO_ZHU_XIN_XI);
$tpl->assign("show_recent_fh", 1);
$tpl->assign("new_one", 0);

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  $err_msg = "post error";
}else
{
  if (empty($_GET['uid']))
    $err_msg = "query failed";
  else
  {
    $rows = crm_db::query_shipper_by_uid($_GET['uid']);
    if (!$rows || count($rows) == 0)
      $err_msg = "query failed";
    else
    {
      $tpl->assign("uid", $_GET['uid']);
      $tpl->assign("linkman", stripslashes($rows[0]['linkman']));
      $tpl->assign("phone_num", $rows[0]['phone_num']);
      $tpl->assign("ent_name", stripslashes($rows[0]['ent_name']));
      $tpl->assign("address", stripslashes($rows[0]['address']));
      $tpl->assign("ent_desc", stripslashes($rows[0]['ent_desc']));
      $tpl->assign("bl_photo", empty($rows[0]['bl_photo']) ? '' : "image/" . $rows[0]['bl_photo']);
      $recent_fh_num = 1;
    }
  }
}

$tpl->assign("err_msg", $err_msg);
$tpl->assign("recent_fh_num", $recent_fh_num);
$tpl->assign("inc_name", "huo_zhu_info.html");
$tpl->display("home.html");
