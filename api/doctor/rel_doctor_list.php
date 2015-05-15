<?php

require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

$ret_code = 0;
$ret_body = array();

do {
  if (empty($_GET['doctor_id'])) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $doctor_id = (int)$_GET['doctor_id'];
  if ($doctor_id <= 0) {
    $ret_code = ERR_PARAM_INVALID;
    break;
  }
  $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
  if ($doctor_info === false) {
    $ret_code = ERR_DB_ERROR;
    break;
  } elseif (empty($doctor_info)) {
    $ret_code = ERR_DOCTOR_NOT_EXIST;
    break;
  }

  $doctor_list = array();
  $disease_list = tb_disease_rel_doctor::query_doctor_rel_disease($doctor_id);
  if (!empty($disease_list)) {
    $disease_list = array_map(function ($r) { return (int)$r['disease_id'];}, $disease_list);
    foreach ($disease_list as $disease) {
      $dl = tb_disease_rel_doctor::query_disease_rel_doctor_list($disease);
      if (!empty($dl)) {
        $dl = array_map(function ($r) { return (int)$r['doctor_id'];}, $dl);
        $real_dl = array();
        foreach ($dl as $id) {
          if ($id != $doctor_id && !in_array($id, $doctor_list)) {
            $real_dl[] = $id;
          }
        }
        if (!empty($real_dl)) {
          $doctor_list = array_merge($doctor_list, $real_dl);
        }
        if (count($doctor_list) > 20) {
          break;
        }
      }
    }
  }

  $doctor_detail_list = fn_doctor::build_doctor_detail_list_from_id_list($doctor_list);

  $ret_body['list'] = $doctor_detail_list;
} while (false);

$ret_body['code'] = (int)$ret_code;
$ret_body['desc'] = $ERRORS[$ret_code];

echo json_encode($ret_body);
