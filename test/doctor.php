<?php

$doctor_phone_nums = array();
$doctor_test_phone_num = 100;
$doctor_phone_num_r = 13400000000 + mt_rand(1, 100000000);
//$doctor_phone_num_r = 13400000000;
for ($i = $doctor_phone_num_r; $i < $doctor_phone_num_r + $doctor_test_phone_num; $i++) {
    $doctor_phone_nums[] = $i;
}
printf("test doctor phone_num %d\n", count($doctor_phone_nums));

// add_doctor
$add_ok_doctor_list = array(); // array(phone_num => array);
function test_add_doctor($users) {
  global $host;
  global $get_timeout;
  global $add_ok_doctor_list;
  $add_ok = 0;
  foreach ($users as $phone_num) {
    $sex = mt_rand(0, 1);
    $ret = json_decode(file_get_contents("http://{$host}/api/add_doctor.php?name=彭好宇&sex={$sex}&phone_num={$phone_num}", false, $get_timeout), true);
    if ((int)$ret['code'] == 0) {
      $add_ok++;
      $add_ok_doctor_list[$phone_num] = (int)$ret['id'];
    } else {
      printf("%s add_doctor failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return $add_ok;
}
$add_ok_num = 0;
$begin_time = microtime(true);
$add_ok_num = test_add_doctor($doctor_phone_nums);
$diff = round(microtime(true) - $begin_time, 3);
printf("add_doctor ok %d %s (%s req/sec)\n", $add_ok_num, $diff, round($add_ok_num/$diff, 2));
