<?php

function test_user_home($phone_nums) {
  global $host;
  global $get_timeout;
   $user_home_ok = 0;
  foreach ($phone_nums as $phone_num => $sid) {
    $ret = json_decode(file_get_contents("http://{$host}/api/user_home.php?sid={$sid}", false, $get_timeout), true);
    if ((int)$ret['code'] == 0) {
      $user_home_ok++;
    } else {
      printf("%s user_home failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return $user_home_ok;
}
$begin_time = microtime(true);
$user_home_ok_num = test_user_home($login_ok_users);
$diff = round(microtime(true) - $begin_time, 3);
printf("user_home ok %d %s (%s req/sec)\n", $user_home_ok_num, $diff, round($user_home_ok_num/$diff, 2));
