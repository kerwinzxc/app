<?php

// home 
function test_home($users) {
  global $host;
  global $get_timeout;
  $home_ok = 0;
  foreach ($users as $sid) {
    $ret = json_decode(file_get_contents("http://{$host}/api/home.php?sid={$sid}", false, $get_timeout), true);
    if ((int)$ret['code'] == 0) {
      $home_ok++;
    } else {
      printf("%s home failed [%s]\n", $sid, $ret['desc']);
    }
  }
  return $home_ok;
}
$begin_time = microtime(true);
$home_ok_num = test_home(array_values($login_ok_users));
$diff = round(microtime(true) - $begin_time, 3);
printf("home ok %d %s (%s req/sec)\n", $home_ok_num, $diff, round($home_ok_num/$diff, 2));
