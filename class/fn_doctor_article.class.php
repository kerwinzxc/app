<?php

class fn_doctor_article
{
  public static function build_doctor_article_brief_list($article_list)
  {
    $real_article_list = array();
    foreach ($article_list as $article) {
      $article_brief = array();
      self::build_doctor_article_brief($article, $article_brief);
      if (!empty($article_brief)) {
        $real_article_list[] = $article_brief;
      }
    }
    return $real_article_list;
  }
  public static function build_doctor_article_brief($article, &$article_brief)
  {
    $doctor_info = tb_doctor::query_doctor_by_id($article['doctor_id']);
    if (empty($doctor_info)) { return false; }

    $article_brief['author'] = $doctor_info['name'];
    $article_brief['icon_url'] = $article['icon_url'];
    $article_brief['topic'] = $article['topic'];
    $article_brief['c_time'] = (int)$article['c_time'];
    $article_id = $article['id'];
    $article_brief['article_url'] = "http://192.168.0.220/api/article/article_view.php?id={$article_id}";
    return true;
  }
};
