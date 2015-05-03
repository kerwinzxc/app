<?php

require_once __DIR__ . '/../init.php';

$host = "127.0.0.1";
$test_phone_num = 10;
$doctor_test_phone_num = 10;
$get_timeout = stream_context_create(array('http' => array('timeout' => 5))); 

$phone_nums = array();
$phone_num_r = 13800000000 + mt_rand(1, 100000000);
$phone_num_r = 13743200140;
for ($i = $phone_num_r; $i < $phone_num_r + $test_phone_num; $i++) {
  $phone_nums[] = $i;
}
printf("test phone_num %d\n", count($phone_nums));

$doctor_phone_nums = array();
$doctor_phone_num_r = 13400000000 + mt_rand(1, 100000000);
$doctor_phone_num_r = 13923100140;
for ($i = $doctor_phone_num_r; $i < $doctor_phone_num_r + $doctor_test_phone_num; $i++) {
    $doctor_phone_nums[] = $i;
}
printf("test doctor phone_num %d\n", count($doctor_phone_nums));


$test_modules = array('reg', 'login', 'user_patient', 'doctor', 'user_gz_doctor', 'user_gz_ke_shi', 'user_gz_ba', 'patient_emr', 'ba','user');
//$test_modules = array('login', 'doctor');
//$test_modules = array('reg');
foreach ($test_modules as $module) {
  require_once __DIR__ . "/{$module}.php";
}
