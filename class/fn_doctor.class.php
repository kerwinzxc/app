<?php

class fn_doctor
{
  public static function build_doctor_detail_list_from_id_list($doctor_list)
  {
    $doctor_detail_list = array();
    foreach ($doctor_list as $doctor_id) {
      $doctor_info = tb_doctor::query_doctor_by_id($doctor_id);
      if (empty($doctor_info)) {
        continue;
      }
      $doctor_detail_list[] = self::build_doctor_detail($doctor_info);
    }
    return $doctor_detail_list;
  }
  public static function build_doctor_detail_list_from_info_list($doctor_list)
  {
    $doctor_detail_list = array();
    foreach ($doctor_list as $doctor_info) {
      $doctor_detail_list[] = self::build_doctor_detail($doctor_info);
    }
    return $doctor_detail_list;
  }
  public static function build_doctor_detail($doctor_info)
  {
    $doctor_detail = array();
    $doctor_detail['doctor_id'] = (int)$doctor_info['id'];
    $doctor_detail['name'] = $doctor_info['name'];
    $doctor_detail['sex'] = (int)$doctor_info['sex'];
    $doctor_detail['classify'] = (int)$doctor_info['classify'];
    $doctor_detail['icon_url'] = $doctor_info['icon_url'];
    $doctor_detail['ke_shi'] = ke_shi::get_name_by_id((int)$doctor_info['ke_shi']);
    $doctor_detail['tec_title'] = (int)$doctor_info['tec_title'];
    $doctor_detail['aca_title'] = (int)$doctor_info['aca_title'];
    $doctor_detail['adm_title'] = (int)$doctor_info['adm_title'];
    $doctor_detail['hospital'] = $doctor_info['hospital'];
    $doctor_detail['expert_in'] = $doctor_info['expert_in'];

    return $doctor_detail;
  }
  public static function query_expert_total_num()
  {
    return tb_doctor::query_doctor_total_num('classify=1');
  }
  public static function query_expert_order_by_limit($start, $offset)
  {
    return tb_doctor::query_doctor_limit('classify=1',
                                         'id desc',
                                         $start,
                                         $offset);
  }
};
