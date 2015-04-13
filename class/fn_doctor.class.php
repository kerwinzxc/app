<?php

class fn_doctor
{
  public static function build_doctor_detail_list($doctor_list)
  {
    $doctor_detail_list = array();
    foreach ($doctor_list as $doctor_id) {
      $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
      if (empty($doctor_info)) {
        continue;
      }
      $doctor_detail = array();
      $doctor_detail['doctor_id'] = (int)$doctor_info['id'];
      $doctor_detail['name'] = $doctor_info['name'];
      $doctor_detail['sex'] = (int)$doctor_info['sex'];
      $doctor_detail['icon_url'] = $doctor_info['icon_url'];
      $doctor_detail['title'] = (int)$doctor_info['title'];
      $doctor_detail['hospital'] = $doctor_info['hospital'];
      $doctor_detail['expert_in'] = $doctor_info['expert_in'];

      $doctor_detail_list[] = $doctor_detail;
    }
    return $doctor_detail_list;
  }
};
