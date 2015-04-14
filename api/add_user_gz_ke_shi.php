<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

define('MAX_GZ_KE_SHI_NUMBER', 10);

$ret_code = 0;
$result = array();

do {
  if (empty($_GET['sid'])
      || empty($_GET['ke_shi'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sid = $_GET['sid'];
  $ke_shi_list = explode(',', $_GET['ke_shi']);
  if (!user_session::is_sid($sid)
      || empty($ke_shi_list)
      || count($ke_shi_list) > MAX_GZ_KE_SHI_NUMBER) {
    $ret_code = ERR_PARAM_INVALID;
    break;
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

  $num = tb_user_gz_ke_shi::query_user_guan_zhu_num($user_id);
  if ($num === false
      || ($num + count($ke_shi_list)) >= MAX_GZ_KE_SHI_NUMBER) {
    $ret_code = ERR_USER_GZ_KE_SHI_LIMIT;
    break;
  }

  $gz_list = tb_user_gz_ke_shi::query_user_guan_zhu_list($user_id);
  $gz_list = tb_user_gz_ke_shi::convert_gz_list_to_array_from_db($gz_list);

  $real_to_gz_list = array_diff($ke_shi_list, $gz_list);

  if (empty($real_to_gz_list)) {
    if (tb_user_gz_ke_shi::insert_some_one($user_id, $real_to_gz_list) === false) {
      $ret_code = ERR_DB_ERROR;
      break;
    }
  }

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
