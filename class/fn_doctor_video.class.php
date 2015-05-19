<?php

class fn_doctor_video
{
  public static function build_doctor_video_brief_list($video_list)
  {
    $real_video_list = array();
    foreach ($video_list as $video) {
      $video_brief = array();
      self::build_doctor_video_brief($video, $video_brief);
      if (!empty($video_brief)) {
        $real_video_list[] = $video_brief;
      }
    }
    return $real_video_list;
  }
  public static function build_doctor_video_brief($video, &$video_brief)
  {
    $doctor_info = tb_doctor::query_doctor_by_id($video['doctor_id']);
    if (empty($doctor_info)) { return false; }

    $video_brief['author'] = $doctor_info['name'];
    $video_brief['icon_url'] = $video['icon_url'];
    $video_brief['topic'] = $video['topic'];
    $video_brief['c_time'] = (int)$video['c_time'];
    $video_brief['id'] = (int)$video['id'];
    $video_brief['video_url'] = $video['video_url'];
    return true;
  }
};
