<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once ROOT . 'init.php';
require_once ROOT . 'view/fill_menu_name.inc.php';
require_once ROOT . 'libs/crm_db.inc.php';

$huo_zhu_rows = array();
$page = 1;
$pages = 0;

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  $linkman = $_POST['linkman'];
  $phone_num = $_POST['phone_num'];
  $employe_id = $_POST['employe_id'];

  if (!empty($linkman))
  {
    $tpl->assign("linkman", $linkman);
    if (!empty($where))
      $where = $where . " and linkman='$linkman'";
    else
      $where = "linkman='$linkman'";
  }
  if (!empty($phone_num))
  {
    $tpl->assign("phone_num", $phone_num);
    if (!empty($where))
      $where = $where . " and phone_num='$phone_num'";
    else
      $where = "phone_num='$phone_num'";
  }
  if (!empty($employe_id))
  {
    $tpl->assign("employe_id", $employe_id);
    if (!empty($where))
      $where = $where . " and employe_id='$employe_id'";
    else
      $where = "employe_id='$employe_id'";
  }
  if (!empty($where))
    $huo_zhu_rows = crm_db::query_shipper($where);
}else
{
  $page = $_GET['p'];
  if (empty($page)) $page = 1;
  $pages = crm_db::select_shipper_count();
  $huo_zhu_rows = crm_db::select_shipper(($page-1)*10);
}

$tpl->assign("content_title", S_HUO_ZHU_CHA_XUN);
$tpl->assign("huo_zhu_rows", $huo_zhu_rows === false ? array() : $huo_zhu_rows);
$tpl->assign("inc_name", "huo_zhu_query.html");
$tpl->assign("page", $page);
$tpl->assign("pages", $pages);

$tpl->display("home.html");
