<?php

// reg user
$reg_ok_users = array();
function test_reg_user($phone_nums) {
  global $host;
  global $get_timeout;
  global $reg_ok_users;
  foreach ($phone_nums as $phone_num) {
    $ret = json_decode(util::post_data("http://{$host}/api/u/reg.php",
                                       array('user' => "$phone_num",
                                             'passwd' => "000000")), true);
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
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("reg users ok %d %s (%s req/sec)\n", $reg_ok_num, $diff, round($reg_ok_num/$diff, 2));
