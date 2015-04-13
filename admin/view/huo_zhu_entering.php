<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once ROOT . 'init.php';
require_once ROOT . 'view/fill_menu_name.inc.php';
require_once ROOT . 'libs/crm_db.inc.php';
require_once ROOT . 'libs/func.inc.php';

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
  $tpl->assign("content_title", S_HUO_ZHU_LU_RU);
  $tpl->assign("huo_zhu_info_title", S_HUO_ZHU_XIN_XI);
  $tpl->assign("new_one", 1);
  $tpl->assign("inc_name", "huo_zhu_info.html");

  $tpl->display("home.html");
}else if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  $err_msg = '';
  $linkman = $_POST['linkman'];
  $phone_num = $_POST['phone_num'];
  $ent_name = $_POST['ent_name'];
  $address = $_POST['address'];
  $ent_desc = $_POST['ent_desc'];

  while (true)
  {
    if (strlen($linkman) > 15 || strlen($linkman) < 3)
    {
      $err_msg = "联系人姓名错误";
      break;
    }
    if (!verify_phone_num($phone_num))
    {
      $err_msg = "电话格式错误";
      break;
    }

    if (crm_db::shipper_is_exist($phone_num))
    {
      $err_msg = "货主已经存在";
      break;
    }else
    {
      //upload file
      $photos = array('bl_photo' => '');
      foreach ($photos as $photo => $fn)
      {
        $filename = $_FILES[$photo]["name"];
        if (empty($filename))
          continue;
        if ($_FILES[$photo]["error"] > 0)
        {
          $err_msg = 'Return Code: ' . $_FILES[$photo]["error"];
          break;
        }
        if ($_FILES[$photo]["size"] > 2*1024*1024)
        {
          $err_msg = $filename . " 图片大小超出限制(2M)";
          break;
        }
        $filename = md5($user . $filename . uniqid(microtime())) . "." . get_file_ext($filename);
        move_uploaded_file($_FILES[$photo]['tmp_name'], ROOT . 'image/' . $filename);
        $photos[$photo] = $filename;
      }
      if ($err_msg != '')
        break;
      // upload end
      $last_id = crm_db::get_last_shipper_id();
      if ($last_id == 0)
      {
        $err_msg = "录入失败";
      }else
      {
        $user = $_SESSION['user']['user'];
        if (!crm_db::insert_shipper($last_id,
          $linkman,
          $phone_num,
          $ent_name,
          $address,
          $ent_desc,
          $photos['bl_photo'],
          $user,
          1))
          $err_msg = "录入失败";
        else
        {
          $err_msg = '录入成功！';
        }
      }
    }
    break;
  } // end of `while (true)'
  alert_and_redirect($err_msg, 'view/huo_zhu_entering.php');
}
