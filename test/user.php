<?php

function test_user_home($phone_nums) {
  global $host;
  global $get_timeout;
  $user_home_ok = 0;
  foreach ($phone_nums as $phone_num => $sid) {
    $ret = json_decode(file_get_contents("http://{$host}/api/u/user_home.php?sid={$sid}", false, $get_timeout), true);
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

function test_reset_passwd($users, $passwd, $new_passwd) {
  global $host;
  global $get_timeout;
  $reset_passwd_ok = 0;
  foreach ($users as $phone_num => $sid) {
    $ret = json_decode(util::post_data("http://{$host}/api/u/reset_passwd.php",
                                       array("sid" => "{$sid}",
                                             "passwd" => $passwd,
                                             "new_passwd" => $new_passwd)), true);
    if ((int)$ret['code'] == 0) {
      $reset_passwd_ok++;
    } else {
      printf("%s reset_passwd failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return $reset_passwd_ok;
}
$begin_time = microtime(true);
$reset_passwd_ok_num = test_reset_passwd($login_ok_users, "000000", "123456");
$diff = round(microtime(true) - $begin_time, 3);
printf("reset_passwd ok %d %s (%s req/sec)\n", $reset_passwd_ok_num, $diff, round($reset_passwd_ok_num/$diff, 2));

$begin_time = microtime(true);
$reset_passwd_ok_num = test_reset_passwd($login_ok_users, "123456", "000000");
$diff = round(microtime(true) - $begin_time, 3);
printf("reset_passwd ok %d %s (%s req/sec)\n", $reset_passwd_ok_num, $diff, round($reset_passwd_ok_num/$diff, 2));


