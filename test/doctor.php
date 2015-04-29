<?php

// add_doctor
$add_ok_doctor_list = array(); // array(phone_num => array);
$doctor_names = array('乔峰', '段誉', '虚竹', '南慕容', '郭大侠');
function test_add_doctor($users) {
  $add_ok = 0;
  global $add_ok_doctor_list;
  global $doctor_names;
  foreach ($users as $phone_num) {
    $di = tb_doctor::query_doctor_by_phone_num($phone_num);
    if (empty($di)) {
      $hospital_rand = 300 + mt_rand(0, 99);
      $new_doctor_id = tb_doctor::insert_new_one($phone_num,
                                                 md5('000000'),
                                                 'cuisw',
                                                 0,
                                                 1,
                                                 $doctor_names[array_rand($doctor_names)],
                                                 mt_rand(0, 1),
                                                 'http://www.didikuaiyi.com/admin/image/1e7371a8cdfb8752a3d289c9200f68b6.png',
                                                 'http://www.didikuaiyi.com/admin/image/1e7371a8cdfb8752a3d289c9200f68b6_200x200.png',
                                                 1,
                                                 1,
                                                 1,
                                                 0,
                                                 "解放军{$hospital_rand}医院",
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

function test_search_doctor()
{
  global $host;
  global $get_timeout;
  global $doctor_names;
  $name = urlencode($doctor_names[array_rand($doctor_names)]);
  $ke_shi = mt_rand(1, 1);
  $classify = mt_rand(1, 1);
  $page = mt_rand(0, 5);
  $search_ok = 0;
  $ret = json_decode(file_get_contents("http://{$host}/api/search_doctor.php?name={$name}&ke_shi={$ke_shi}&classify={$classify}&p={$page}", false, $get_timeout), true);
  if ((int)$ret['code'] == 0) {
    $search_ok += count($ret['list']);
  } else {
    printf("search_doctor failed [%s]\n", $ret['desc']);
  }
  return $search_ok;
}
$search_ok_num = 0;
$begin_time = microtime(true);
$search_ok_num = test_search_doctor();
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("search_doctor ok %d %s (%s req/sec)\n", $search_ok_num, $diff, round($search_ok_num/$diff, 2));
