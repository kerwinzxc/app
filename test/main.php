<?php

require_once __DIR__ . '/../init.php';

$host = "127.0.0.1";
$test_phone_num = 100;
$get_timeout = stream_context_create(array('http' => array('timeout' => 5))); 

$phone_nums = array();
$phone_num_r = 13800000000 + mt_rand(1, 100000000);
$phone_num_r = 13800000000;
for ($i = $phone_num_r; $i < $phone_num_r + $test_phone_num; $i++) {
  $phone_nums[] = $i;
}
printf("test phone_num %d\n", count($phone_nums));

//$test_modules = array('reg', 'login', 'user_patient', 'doctor', 'user_guan_zhu');
$test_modules = array('reg', 'login');
foreach ($test_modules as $module) {
  require_once __DIR__ . "/{$module}.php";
}
