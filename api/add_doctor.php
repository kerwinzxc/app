<?php

require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$result = array();

do {
  if (empty($_GET['name'])
      || !isset($_GET['sex'])
      || empty($_GET['phone_num'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }

  $sex = $_GET['sex'];
  $name = $_GET['name'];
  $phone_num = $_GET['phone_num'];
  if (!check::is_phone_num($phone_num)
      || !check::is_sex($sex)
      || !check::is_name($name)) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  if (get_magic_quotes_gpc()) {
    $name = stripslashes($name);
  }

  $new_doctor_id = tb_doctor::insert_new_one($phone_num,
                                             md5('000000'),
                                             $name,
                                             $sex,
                                             time());
  if ($new_doctor_id === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  }
  $ret_body['id'] = $new_doctor_id;

} while (false);

$ret_body['code'] = $ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
