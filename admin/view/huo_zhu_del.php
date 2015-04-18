<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/crm_db.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';

$err_msg = '';
if ($_SERVER['REQUEST_METHOD'] == "GET")
{
  if (empty($_GET['uid']))
    $err_msg = "参数错误";
  else
  {
    $rows = crm_db::query_shipper_by_uid($_GET['uid']);
    if (!$rows || count($rows) == 0)
      $err_msg = "此车主不存在";
    else
    {
      $user = $_SESSION['user']['user'];
      if ($rows[0]['employe_id'] == $user)
      {
        crm_db::del_shipper($_GET['uid']) or die;
      }else
        $err_msg = '您不是录入者，不能删除';
    }
  }
}
alert_and_redirect($err_msg, 'view/huo_zhu_query.php');