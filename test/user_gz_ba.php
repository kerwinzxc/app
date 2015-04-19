<?php

// add_user_gz_ba
$add_ok_user_gz_ba_list = array(); // array(phone_num => array);
function test_add_user_gz_ba($users) {
  global $host;
  global $get_timeout;
  $add_ok = 0;
  foreach ($users as $phone_num => $sid) {
    $ba_id = mt_rand(1, 9999999);
    $ret = json_decode(file_get_contents("http://{$host}/api/u/gz_ba.php?do=add&sid={$sid}&ba_id={$ba_id}", false, $get_timeout), true);
    if ((int)$ret['code'] == 0) {
      $add_ok++;
    } else {
      printf("%s add_user_gz_ba failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return $add_ok;
}
$add_ok_num = 0;
$begin_time = microtime(true);
for ($i = 0; $i < 3; $i++) {
  $add_ok_num += test_add_user_gz_ba($login_ok_users);
}
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("add_user_gz_ba ok %d %s (%s req/sec)\n", $add_ok_num, $diff, round($add_ok_num/$diff, 2));

// get_user_gz_ba_list // return array(phone_num = > array(guan_zhu_info))
$all_user_gz_ba_list = array();
function test_get_user_gz_ba_list($users) {
  global $host;
  global $get_timeout;
  global $all_user_gz_ba_list;
  $get_ok = 0;
  foreach ($users as $phone_num => $sid) {
    $ret = json_decode(file_get_contents("http://{$host}/api/u/gz_ba.php?do=get&sid={$sid}", false, $get_timeout), true);
    if ((int)$ret['code'] == 0) {
      $all_user_gz_ba_list[$phone_num] = $ret['list'];
      $get_ok += count($ret['list']);
    } else {
      printf("%s get_user_gz_ba_list failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return $get_ok;
}
$begin_time = microtime(true);
$all_user_gz_ba_list = array();
$get_ok_num = test_get_user_gz_ba_list($login_ok_users);
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("get user guan_zhu list ok %d %s (%s req/sec)\n", $get_ok_num, $diff, round($get_ok_num/$diff, 2));

// del_user_gz_ba
function test_del_user_gz_ba() {
  global $host;
  global $get_timeout;
  global $login_ok_users;
  global $all_user_gz_ba_list;
  $del_ok = 0;
  foreach ($all_user_gz_ba_list as $phone_num => $my_guan_zhu_list) {
    foreach ($my_guan_zhu_list as $ba_id) {
      $sid = $login_ok_users[$phone_num];
      $ret = json_decode(file_get_contents("http://{$host}/api/u/gz_ba.php?do=del&sid={$sid}&ba_id={$ba_id}", false, $get_timeout), true);
      if ((int)$ret['code'] == 0) {
        $del_ok++;
        break;
      } else {
        printf("%s del_user_gz_ba failed [%s]\n", $phone_num, $ret['desc']);
      }
    }
  }
  return $del_ok;
}
$del_ok_num = 0;
$begin_time = microtime(true);
for ($i = 0; $i < 2; $i++) {
  $del_ok_num += test_del_user_gz_ba();
}
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("del_user_gz_ba ok %d %s (%s req/sec)\n", $del_ok_num, $diff, round($del_ok_num/$diff, 2));

$all_user_gz_ba_list = array();
test_get_user_gz_ba_list($login_ok_users);
