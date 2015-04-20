<?php

class fn_doctor_article
{
  public static function build_doctor_article_brief_list($article_list)
  {
    $real_article_list = array();
    foreach ($article_list as $article) {
      $doctor_info = tb_doctor::query_doctor_by_id($article['doctor_id']);
      if (empty($doctor_info)) {
        continue;
      }
      $article_brief = array();
      $article_brief['name'] = $doctor_info['name'];
      $article_brief['article_id'] = (int)$article['id'];
      $article_brief['topic'] = $article['topic'];
      $article_brief['c_time'] = (int)$article['c_time'];
      $real_article_list[] = $article_brief;
    }
    return $real_article_list;
  }
};
