<?php

class fn_ba_topic_comment
{
  public static function build_topic_comment_list($topic_comment_list)
  {
    $topic_comment_detail_list = array();
    foreach ($topic_comment_list as $info) {
      $topic_comment = array();
      $topic_comment['comment_id'] = (int)$info['id'];

      $user_id = (int)$info['user_id'];
      $user_name = '';
      $icon_url = '';
      tb_user::query_name_by_id($user_id, $user_name, $icon_url);
      $topic_comment['author'] = $user_name;
      $topic_comment['icon_url'] = $icon_url;

      $topic_comment['content'] = $info['content'];
      $topic_comment['c_time'] = (int)$info['c_time'];

      $topic_comment_detail_list[] = $topic_comment;
    }
    return $topic_comment_detail_list;
  }
};
