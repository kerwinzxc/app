<?php

if (empty($all_user_patient_list)) {
  printf("all_user_patient_list is empty!!!!\n");
  exit;
}
// add_patient_emr
$add_ok_patient_emr_list = array(); // array(phone_num => array);
function test_add_patient_emr($users) {
  global $host;
  global $get_timeout;
  global $add_ok_patient_emr_list;
  global $login_ok_users;
  $add_ok = 0;
  foreach ($users as $phone_num => $patient_list) {
    $sid = $login_ok_users[$phone_num];
    foreach ($patient_list as $patient_info) {
      $ret = json_decode(util::post_data("http://{$host}/api/u/add_emr.php",
                                         array("sid" => "{$sid}",
                                               "patient_id" => $patient_info['patient_id'],
                                               "sd_time" => "2015-03-16 04:15:32",
                                               "doctor_name" => "彭好宇",
                                               "hospital" => "北医'三院",
                                               "ke_shi" => "sdfkfdffd",
                                               "doctor_diagnosis" => "xxxx\x'xx",
                                               "doctor_tell" => "yyy'yyyyyyyyyyyyyyyyyyyyyyyy")),
                         true);
      if ((int)$ret['code'] == 0) {
        $add_ok++;
        $patient_id = $patient_info['patient_id'];
        if (isset($add_ok_patient_emr_list[$phone_num])) {
          $v = $add_ok_patient_emr_list[$phone_num];
          if (!isset($v[$patient_id])) {
            $v[$patient_id] = array();
          }
          $v[$patient_id][] = (int)$ret['emr_id'];
          $add_ok_patient_emr_list[$phone_num] = $v;
        } else {
          $add_ok_patient_emr_list[$phone_num] = array();
          $patient_id = $patient_info['patient_id'];
          $add_ok_patient_emr_list[$phone_num][$patient_id] = array((int)$ret['emr_id']);
        }
      } else {
        printf("%s add_patient_emr failed [%s]\n", $phone_num, $ret['desc']);
      }
    }
  }
  return $add_ok;
}
$add_ok_num = 0;
$begin_time = microtime(true);
for ($i = 0; $i < 3; $i++) {
  $add_ok_num += test_add_patient_emr($all_user_patient_list);
}
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("add_patient_emr ok %d %s (%s req/sec)\n", $add_ok_num, $diff, round($add_ok_num/$diff, 2));

// get_patient_emr_list // return array(phone_num = > array(patient_info))
$all_patient_emr_list = array();
function test_get_patient_emr_list($users) {
  global $host;
  global $get_timeout;
  global $all_patient_emr_list;
  global $login_ok_users;
  $get_ok = 0;
  foreach ($users as $phone_num => $patient_list) {
    $sid = $login_ok_users[$phone_num];
    foreach ($patient_list as $patient_info) {
      $patient_id = $patient_info['patient_id'];
      $ret = json_decode(file_get_contents("http://{$host}/api/u/emr.php?do=get_list&sid={$sid}&patient_id={$patient_id}", false, $get_timeout), true);
      if ((int)$ret['code'] == 0) {
        if (isset($all_patient_emr_list[$phone_num])) {
          $v = $all_patient_emr_list[$phone_num];
          $v[$patient_id] = $ret['list'];
        } else {
          $v = array();
          $v[$patient_id] = $ret['list'];
          $all_patient_emr_list[$phone_num] = $v;
        }
        $get_ok += count($ret['list']);
      } else {
        printf("%s get_patient_emr_list failed [%s]\n", $phone_num, $ret['desc']);
      }
    }
  }
  return $get_ok;
}
$begin_time = microtime(true);
$all_patient_emr_list = array();
$get_ok_num = test_get_patient_emr_list($all_user_patient_list);
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("get user patient emr list ok %d %s (%s req/sec)\n", $get_ok_num, $diff, round($get_ok_num/$diff, 2));

// del_patient_emr
function test_del_patient_emr() {
  global $host;
  global $get_timeout;
  global $login_ok_users;
  global $all_patient_emr_list;
  $del_ok = 0;
  foreach ($all_patient_emr_list as $phone_num => $my_patients) {
    $sid = $login_ok_users[$phone_num];
    foreach ($my_patients as $patient_id => $emr_list) {
      foreach ($emr_list as $emr) {
        $emr_id = $emr['emr_id'];
        $ret = json_decode(file_get_contents("http://{$host}/api/u/emr.php?do=del&sid={$sid}&patient_id={$patient_id}&emr_id={$emr_id}", false, $get_timeout), true);
        if ((int)$ret['code'] == 0) {
          $del_ok++;
          break;
        } else {
          printf("%s del_patient_emr failed [%s]\n", $phone_num, $ret['desc']);
        }
      }
    }
  }
  return $del_ok;
}
$del_ok_num = 0;
$begin_time = microtime(true);
$del_ok_num += test_del_patient_emr();
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("del_patient_emr ok %d %s (%s req/sec)\n", $del_ok_num, $diff, round($del_ok_num/$diff, 2));

$all_patient_emr_list = array();
test_get_patient_emr_list($all_user_patient_list);

