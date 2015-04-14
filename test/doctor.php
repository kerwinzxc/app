<?php

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
                                                 'cuisw',
                                                 1,
                                                 $names[array_rand($names)],
                                                 mt_rand(0, 1),
                                                 'http://photocdn.sohu.com/20150413/Img411198795.jpg',
                                                 1,
                                                 1,
                                                 1,
                                                 '解放军306医院',
                                                 '本教程提供了几款php教程  删除字符串中的空格多种方法哦',
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
