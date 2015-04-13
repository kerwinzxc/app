<?php

function escape_input($value)
{
  // 去除斜杠
  if (get_magic_quotes_gpc())
    $value = stripslashes($value);
  return mysql_escape_string($value);
}
function alert_and_redirect($err_msg, $to_url)
{
  $redirect = BASE_URL . $to_url;
  $alert = "alert('$err_msg')";
  if (empty($err_msg))
    $alert = '';
  echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
  echo "<script language='javascript'>$alert;parent.location.href='$redirect';</script>";
  exit;
}
function get_distance($lng1, $lat1, $lng2, $lat2)
{
  $EARTH_RADIUS = 6378.137; // 地球半径
  $PI = 3.1415926;
  $rad_lat1 = $lat1 * $PI / 180.0;
  $rad_lat2 = $lat2 * $PI / 180.0;
  $a = $rad_lat1 - $rad_lat2;
  $b = ($lng1 * $PI / 180.0) - ($lng2 * $PI / 180.0);

  $s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($rad_lat1) * cos($rad_lat2) * pow(sin($b/2),2)));
  $s = $s * $EARTH_RADIUS;
  $s = round($s * 1000);
  return $s;
}
