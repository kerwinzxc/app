<?php

$doctor_phone_nums = array();
$doctor_test_phone_num = 10;
$doctor_phone_num_r = 13400000000 + mt_rand(1, 100000000);
//$doctor_phone_num_r = 13400000000;
for ($i = $doctor_phone_num_r; $i < $doctor_phone_num_r + $doctor_test_phone_num; $i++) {
    $doctor_phone_nums[] = $i;
}
printf("test doctor phone_num %d\n", count($doctor_phone_nums));

// add_doctor
$add_ok_doctor_list = array(); // array(phone_num => array);
function test_add_doctor($users) {
  $names = array('乔峰', '段誉', '虚竹', '南慕容', '郭大侠');
  $add_ok = 0;
  global $add_ok_doctor_list;
  foreach ($users as $phone_num) {
    $di = tb_doctor::query_doctor_by_phone_num($phone_num);
    if (empty($di)) {
      $new_doctor_id = tb_doctor::insert_new_one($phone_num,
                                                 md5('000000'),
                                                 $names[array_rand($names)],
                                                 mt_rand(0, 1),
                                                 '',
                                                 1,
                                                 1,
                                                 '',
                                                 '',
                                                 time());
      $add_ok_doctor_list[$phone_num] = $new_doctor_id;
      $add_ok++;
    }
  }
  return $add_ok;
}
$add_ok_num = 0;
$begin_time = microtime(true);
$add_ok_num = test_add_doctor($doctor_phone_nums);
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("add_doctor ok %d %s (%s req/sec)\n", $add_ok_num, $diff, round($add_ok_num/$diff, 2));
