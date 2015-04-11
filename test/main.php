<?php

require_once __DIR__ . '/../init.php';

$host = "127.0.0.1";
$test_phone_num = 1000;
$get_timeout = stream_context_create(array('http' => array('timeout' => 3))); 

$phone_nums = array();
$phone_num_r = 13800000000 + mt_rand(1, 100000000);
for ($i = $phone_num_r; $i < $phone_num_r + $test_phone_num; $i++) {
  $phone_nums[] = $i;
}
printf("test phone_num %d\n", count($phone_nums));

// reg user
$reg_ok_users = array();
function test_reg_user($phone_nums) {
  global $host;
  global $get_timeout;
  global $reg_ok_users;
  foreach ($phone_nums as $phone_num) {
    $ret = json_decode(file_get_contents("http://{$host}/api/reg.php?user={$phone_num}&passwd=000000", false, $get_timeout), true);
    if ((int)$ret['code'] == 0) {
      $reg_ok_users[] = $phone_num;
    } else {
      printf("reg %s failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return count($reg_ok_users);
}
$begin_time = microtime(true);
$reg_ok_num = test_reg_user($phone_nums);
$diff = round(microtime(true) - $begin_time, 3);
printf("reg users ok %d %s (%s req/sec)\n", $reg_ok_num, $diff, round($reg_ok_num/$diff, 2));

// login
$login_ok_users = array(); // array(phone_num => sid)
function test_login($phone_nums) {
  global $host;
  global $get_timeout;
  global $login_ok_users;
  foreach ($phone_nums as $phone_num) {
    $ret = json_decode(file_get_contents("http://{$host}/api/login.php?user={$phone_num}&passwd=000000", false, $get_timeout), true);
    if ((int)$ret['code'] == 0) {
      $login_ok_users[$phone_num] = $ret['sid'];
    } else {
      printf("%s login failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return count($login_ok_users);
}
$begin_time = microtime(true);
$login_ok_num = test_login($reg_ok_users);
$diff = round(microtime(true) - $begin_time, 3);
printf("login users ok %d %s (%s req/sec)\n", $login_ok_num, $diff, round($login_ok_num/$diff, 2));

// home 
function test_home($users) {
  global $host;
  global $get_timeout;
  $home_ok = 0;
  foreach ($users as $sid) {
    $ret = json_decode(file_get_contents("http://{$host}/api/home.php?sid={$sid}", false, $get_timeout), true);
    if ((int)$ret['code'] == 0) {
      $home_ok++;
    } else {
      printf("%s home failed [%s]\n", $sid, $ret['desc']);
    }
  }
  return $home_ok;
}
$begin_time = microtime(true);
$home_ok_num = test_home(array_values($login_ok_users));
$diff = round(microtime(true) - $begin_time, 3);
printf("home ok %d %s (%s req/sec)\n", $home_ok_num, $diff, round($home_ok_num/$diff, 2));

// add_user_patient
$add_ok_user_patient_list = array(); // array(phone_num => array);
function test_add_user_patient($users) {
  global $host;
  global $get_timeout;
  global $add_ok_user_patient_list;
  $add_ok = 0;
  foreach ($users as $phone_num => $sid) {
    $city1 = 100 + mt_rand(1, 99);
    $city2 = 100 + mt_rand(1, 99);
    $end = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    $year = 1900 + mt_rand(1, 99);
    $month = str_pad(mt_rand(3, 12), 2, '0', STR_PAD_LEFT);
    $day = str_pad(mt_rand(1, 30), 2, '0', STR_PAD_LEFT);
    $birthday = $year . $month . $day;
    $sex = mt_rand(0, 1);
    $is_default = mt_rand(0, 1);
    $ret = json_decode(file_get_contents("http://{$host}/api/add_user_patient.php?sid={$sid}&name=彭好宇&id_card={$city1}{$city2}{$birthday}{$end}&birthday={$year}-{$month}-{$day}&sex={$sex}&is_default={$is_default}&phone_num=13810421852", false, $get_timeout), true);
    if ((int)$ret['code'] == 0) {
      $add_ok++;
      if (isset($add_ok_user_patient_list[$phone_num])) {
        $v = $add_ok_user_patient_list[$phone_num];
        $v[] = (int)$ret['id'];
        $add_ok_user_patient_list[$phone_num] = $v;
      } else {
        $add_ok_user_patient_list[$phone_num] = array((int)$ret['id']);
      }
    } else {
      printf("%s add_user_patient failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return $add_ok;
}
$add_ok_num = 0;
$begin_time = microtime(true);
for ($i = 0; $i < 3; $i++) {
  $add_ok_num += test_add_user_patient($login_ok_users);
}
$diff = round(microtime(true) - $begin_time, 3);
printf("add_user_patient ok %d %s (%s req/sec)\n", $add_ok_num, $diff, round($add_ok_num/$diff, 2));

// get_user_patient_list // return array(phone_num = > array(patient_info))
$all_user_patient_list = array();
function test_get_user_patient_list($users) {
  global $host;
  global $get_timeout;
  global $all_user_patient_list;
  $get_ok = 0;
  foreach ($users as $phone_num => $sid) {
    $ret = json_decode(file_get_contents("http://{$host}/api/get_user_patient_list.php?sid={$sid}", false, $get_timeout), true);
    if ((int)$ret['code'] == 0) {
      $all_user_patient_list[$phone_num] = $ret['list'];
      $get_ok += count($ret['list']);
    } else {
      printf("%s get_user_patient_list failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return $get_ok;
}
$begin_time = microtime(true);
$all_user_patient_list = array();
$get_ok_num = test_get_user_patient_list($login_ok_users);
$diff = round(microtime(true) - $begin_time, 3);
printf("get user patient list ok %d %s (%s req/sec)\n", $get_ok_num, $diff, round($get_ok_num/$diff, 2));

// del_user_patient
function test_del_user_patient() {
  global $host;
  global $get_timeout;
  global $login_ok_users;
  global $all_user_patient_list;
  $del_ok = 0;
  foreach ($all_user_patient_list as $phone_num => $my_patients) {
    foreach ($my_patients as $patient_info) {
      $patient_id = $patient_info['id'];
      $sid = $login_ok_users[$phone_num];
      $ret = json_decode(file_get_contents("http://{$host}/api/del_user_patient.php?sid={$sid}&patient_id={$patient_id}", false, $get_timeout), true);
      if ((int)$ret['code'] == 0) {
        $del_ok++;
        break;
      } else {
        printf("%s del_user_patient failed [%s]\n", $phone_num, $ret['desc']);
      }
    }
  }
  return $del_ok;
}
$del_ok_num = 0;
$begin_time = microtime(true);
for ($i = 0; $i < 2; $i++) {
  $del_ok_num += test_del_user_patient();
}
$diff = round(microtime(true) - $begin_time, 3);
printf("del_user_patient ok %d %s (%s req/sec)\n", $del_ok_num, $diff, round($del_ok_num/$diff, 2));

$all_user_patient_list = array();
test_get_user_patient_list($login_ok_users);

// set_user_patient
function test_set_default_patient() {
  global $host;
  global $get_timeout;
  global $login_ok_users;
  global $all_user_patient_list;
  $set_ok = 0;
  foreach ($all_user_patient_list as $phone_num => $my_patients) {
    foreach ($my_patients as $patient_info) {
      if ((int)$patient_info['is_default'] != 1) {
        $patient_id = $patient_info['id'];
        $sid = $login_ok_users[$phone_num];
        $ret = json_decode(file_get_contents("http://{$host}/api/set_default_patient.php?sid={$sid}&patient_id={$patient_id}", false, $get_timeout), true);
        if ((int)$ret['code'] == 0) {
          $set_ok++;
          break;
        } else {
          printf("%s set_user_patient failed [%s]\n", $phone_num, $ret['desc']);
        }
      }
    }
  }
  return $set_ok;
}
$set_ok_num = 0;
$begin_time = microtime(true);
$set_ok_num = test_set_default_patient();
$diff = round(microtime(true) - $begin_time, 3);
printf("set_default_patient ok %d %s (%s req/sec)\n", $set_ok_num, $diff, round($del_ok_num/$diff, 2));
