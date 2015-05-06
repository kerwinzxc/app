<?php

class fn_ba_topic
{
  public static function build_topic_info($topic_info, &$ret)
  {
    $ret['topic_id'] = (int)$topic_info['id'];
    $ret['topic'] = $topic_info['topic'];
    $ret['content'] = $topic_info['content'];
    $author_id = (int)$topic_info['user_id'];
    $user_name = '';
    $icon_url = '';
    tb_user::query_name_by_id($author_id, $user_name, $icon_url);
    $ret['author'] = $user_name;
    $ret['icon_url'] = $icon_url;
    $ret['author_id'] = $author_id;
    $ret['c_time'] = (int)$topic_info['c_time'];
  }
  public static function build_topic_brief_list($topic_list)
  {
    $topic_brief_list = array();
    foreach ($topic_list as $topic_info) {
      $topic_brief = array();
      $topic_id = (int)$topic_info['id'];
      $topic_brief['topic_id'] = $topic_id;

      $author_id = (int)$topic_info['user_id'];
      $user_name = '';
      $icon_url = '';
      $topic_brief['author'] = tb_user::query_name_by_id($author_id, $user_name, $icon_url);
      $topic_brief['author_id'] = $author_id;

      $topic_brief['topic'] = $topic_info['topic'];
      $topic_brief['zan'] = (int)$topic_info['zan'];
      $topic_brief['comment'] = (int)$topic_info['coment'];

      $topic_brief['c_time'] = (int)$topic_info['c_time'];

      $topic_brief_list[] = $topic_brief;
    }
    return $topic_brief_list;
  }
};
