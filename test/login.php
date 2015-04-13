<?php

// login
if (!isset($reg_ok_users)) {
  $reg_ok_users = $phone_nums;
}
$login_ok_users = array(); // array(phone_num => sid)
function test_login($phone_nums) {
  global $host;
  global $get_timeout;
  global $login_ok_users;
  foreach ($phone_nums as $phone_num) {
    $ret = json_decode(util::post_data("http://{$host}/api/login.php",
                                       array('user' => "$phone_num",
                                             'passwd' => "000000")), true);
    if ((int)$ret['code'] == 0) {
      $login_ok_users[$phone_num] = $ret['sid'];
    } else {
      printf("%s login failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return count($login_ok_users);
}
$begin_time = microtime(true);
$login_ok_num = test_login($reg_ok_users);
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("login users ok %d %s (%s req/sec)\n", $login_ok_num, $diff, round($login_ok_num/$diff, 2));
