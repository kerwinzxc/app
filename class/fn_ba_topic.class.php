<?php

class fn_ba_topic
{
  public static function build_topic_brief_list($topic_list)
  {
    $topic_brief_list = array();
    foreach ($topic_list as $topic_info) {
      $topic_brief = array();
      $topic_brief['topic_id'] = (int)$topic_info['id'];

      $author_id = (int)$topic_info['user_id'];
      $topic_brief['author'] = tb_user::query_name_by_id($author_id);

      $topic_brief['title'] = $topic_info['title'];
      $topic_brief['useful'] = (int)$topic_info['useful'];
      $topic_brief['useless'] = (int)$topic_info['useless'];
      $topic_brief['c_time'] = $topic_info['c_time'];

      $topic_brief_list[] = $topic_brief;
    }
    return $topic_brief_list;
  }
};
