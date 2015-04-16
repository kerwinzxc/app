<?php

// get_topic_list // return array(phone_num = > array(patient_info))
function test_get_topics_list($users) {
  global $host;
  global $get_timeout;
  global $login_ok_users;
  $get_ok = 0;
  $p = mt_rand(0, 100);
  foreach ($users as $phone_num => $sid) {
    $ret = json_decode(file_get_contents("http://{$host}/api/ba/topics.php?ba_id=2003&p={$p}", false, $get_timeout), true);
    if ((int)$ret['code'] == 0) {
      $get_ok += count($ret['list']);
    } else {
      printf("%s get_topics_list failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return $get_ok;
}
$begin_time = microtime(true);
$get_ok_num = test_get_topics_list($login_ok_users);
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("get topics list ok %d %s (%s req/sec)\n", $get_ok_num, $diff, round($get_ok_num/$diff, 2));

$add_ok_topic_list = array(); // array(phone_num => array);
function test_add_topic($users) {
  global $host;
  global $get_timeout;
  global $add_ok_topic_list;
  global $login_ok_users;
  $add_ok = 0;
  $titles = array("世界最残忍的地方，不是无情，%而是根本没有感情",
                  "恍惚中，我好像回到了初中的\一个暑假午",
                  "去吧！我最好的朋友，带着'你的希望");
  foreach ($users as $phone_num => $sid) {
    $ret = json_decode(util::post_data("http://{$host}/api/ba/post.php",
                                       array("sid" => "{$sid}",
                                             "ba_id" => 2003,
                                             "title" => $titles[array_rand($titles)],
                                             "content" => "张斌很久不见了吧，还在广州吗，孩子会跑了吧，我仍然会回答，是啊，都很好，还是都很好。只不%过真正的张斌已经去了，'只'存在我的电话簿里，我的微信好友里\.",
                                            )),
                       true);
    if ((int)$ret['code'] == 0) {
      $add_ok++;
      $add_ok_topic_list[] = (int)$ret['topic_id'];
    } else {
      printf("%s add_topic failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return $add_ok;
}
$add_ok_num = 0;
$begin_time = microtime(true);
$add_ok_num = test_add_topic($login_ok_users);
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("add_topic ok %d %s (%s req/sec)\n", $add_ok_num, $diff, round($add_ok_num/$diff, 2));

// get_topic_list // return array(phone_num = > array(patient_info))
$all_topic_list = array();
function test_get_topic_list($users) {
  global $host;
  global $get_timeout;
  global $all_topic_list;
  global $login_ok_users;
  $get_ok = 0;
  global $add_ok_topic_list;
  foreach ($users as $phone_num => $sid) {
    $topic_id = $add_ok_topic_list[array_rand($add_ok_topic_list)];
    $p = mt_rand(0, 100);
    $ret = json_decode(file_get_contents("http://{$host}/api/ba/topic.php?topic_id={$topic_id}&p={$p}", false, $get_timeout), true);
    if ((int)$ret['code'] == 0) {
      $get_ok += count($ret['list']);
    } else {
      printf("%s get_topic_list failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return $get_ok;
}
$begin_time = microtime(true);
$all_topic_list = array();
$get_ok_num = test_get_topic_list($login_ok_users);
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("get topic list ok %d %s (%s req/sec)\n", $get_ok_num, $diff, round($get_ok_num/$diff, 2));

// reply
function test_reply_topic() {
  global $host;
  global $get_timeout;
  global $login_ok_users;
  global $add_ok_topic_list;
  $reply_ok = 0;
  foreach ($login_ok_users as $phone_num => $sid) {
    $topic_id = $add_ok_topic_list[array_rand($add_ok_topic_list)];
    $ret = json_decode(util::post_data("http://{$host}/api/ba/reply.php",
                                       array("sid" => "{$sid}",
                                             "topic_id" => $topic_id,
                                             "content" => '著名领军人物创办的移动医疗类的公司，人脉雄厚经验丰富，目前已签入大量三甲医院医生等资源，聚焦爆发型高端移动医疗领域，发展迅猛。管理团队由美国上市公司高管、腾讯新浪多位总监、IBM资深技术主管等组成，多家知名投资公司参与。起点很高、超常规发展、成长空间巨大，是实现互联网梦想、迅速提高经验、扩大人脉的绝佳平台。现寻求优秀技术伙伴，共创辉煌！请联系 010-57108017，简历请发 43458943@qq.com ',
                                            )),
                       true);
    if ((int)$ret['code'] == 0) {
      $reply_ok++;
    } else {
      printf("%s reply_topic failed [%s]\n", $phone_num, $ret['desc']);
    }
  }
  return $reply_ok;
}
$reply_ok_num = 0;
$begin_time = microtime(true);
$reply_ok_num = test_reply_topic();
$diff = round(microtime(true) - $begin_time, 3) + 0.001;
printf("reply_topic ok %d %s (%s req/sec)\n", $reply_ok_num, $diff, round($reply_ok_num/$diff, 2));

