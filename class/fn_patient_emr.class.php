<?php

class fn_patient_emr
{
  public static function build_emr_detail_list($emr_list)
  {
    $emr_detail_list = array();
    foreach ($emr_list as $emr) {
      $emr_detail = array();
      $emr_detail['emr_id'] = (int)$emr['id'];
      $emr_detail['patient_id'] = (int)$emr['patient_id'];
      $emr_detail['sd_time'] = (int)$emr['sd_time'];
      $emr_detail['hospital'] = $emr['hospital'];
      $emr_detail['ke_shi'] = $emr['ke_shi'];
      $emr_detail['doctor_name'] = $emr['doctor_name'];
      $emr_detail['doctor_diagnosis'] = $emr['doctor_diagnosis'];
      $emr_detail['doctor_tell'] = $emr['doctor_tell'];

      $emr_detail_list[] = $emr_detail;
    }
    return $emr_detail_list;
  }
};
