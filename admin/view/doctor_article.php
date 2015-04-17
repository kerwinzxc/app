<?php

require_once dirname(__FILE__) . '/../conf/settings.php';
require_once MNG_ROOT . 'init.php';
require_once MNG_ROOT . 'view/fill_menu_name.inc.php';
require_once MNG_ROOT . 'libs/func.inc.php';
require_once MNG_ROOT . 'autoload.php'; // below smarty

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $tpl->assign("content_title", S_DOCTOR_ARTICLE);
  $tpl->assign("new_one", 1);
  $tpl->assign("inc_name", "doctor_article.html");
  $tpl->assign("h_inc_name", "editor_header.html");

  $tpl->display("home.html");
} else {
  echo $_POST['topic'];
  echo $_POST['editorValue'];
}
