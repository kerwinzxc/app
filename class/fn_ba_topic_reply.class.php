<?php

class fn_ba_topic_reply
{
  public static function build_topic_reply_list($topic_reply_list)
  {
    $topic_reply_list = array();
    foreach ($topic_reply_list as $reply_id) {
      $info = tb_ba_topic_reply::query_topic_replay_by_id($reply_id);
      if (empty($info)) {
        continue;
      }
      $topic_reply = array();
      $topic_reply['reply_id'] = $reply_id;

      $user_id = (int)$info['user_id'];
      $topic_reply['replier_id'] = tb_user::query_name_by_id($user_id);

      $topic_reply['content'] = $info['content'];
      $topic_reply['c_time'] = $info['c_time'];

      $topic_reply_list[] = $topic_reply;
    }
    return $topic_reply_list;
  }
};
