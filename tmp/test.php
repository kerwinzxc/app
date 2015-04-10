<?php

$ip = "127.0.0.1";
for ($i = 13810421800; $i <= 13810421899; $i++) {
  file_get_contents("http://{$ip}/api/reg.php?user={$i}&passwd=123456");
  $ret = json_decode(file_get_contents("http://{$ip}/api/login.php?user={$i}&passwd=123456"), true);
  $sid = $ret['sid'];

  $sex = $i % 2;
  $ret = json_decode(file_get_contents("http://{$ip}/api/add_user_patient.php?sid={$sid}&name=123456&phone_num={$i}&sex={$sex}"), true);
  $ret = json_decode(file_get_contents("http://{$ip}/api/get_user_patient_list.php?sid={$sid}"), true);
  printf("get %s ", $ret['list']);
  if (count($ret['list']) > 1) {
    $patient_id = $ret['list'][1]['id'];
    $ret = json_decode(file_get_contents("http://{$ip}/api/del_user_patient.php?sid={$sid}&patient_id={$patient_id}"), true);
    printf("del %s\n", $ret['patient_id']);
  } else {
    printf("\n");
  }
}
