<?php
require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

if (empty($_GET['id'])) {
  echo "参数错误";
  exit;
}
$article_id = (int)$_GET['id'];
$article_info = tb_doctor_article::query_article_by_id($article_id);
if ($article_info === false || empty($article_info)) {
  echo "查找该文章失败";
  exit;
}
$doctor_info = tb_doctor::query_doctor_by_id($article_info['doctor_id']);
if (!empty($doctor_info)) {
  $article_info['author'] = $doctor_info['name'];
} else {
  $article_info['author'] = '中卫颐康';
}
?>
<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
<style type="text/css">
html { height: 100%; margin-bottom: 1px; }
body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, form, fieldset, input, textarea, p, blockquote, th, td {
  padding: 0;
  margin: 0;
}
fieldset, img {
  border: 0;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
}
ol, ul {
  list-style: none;
}
address, caption, cite, code, dfn, em, strong, th, var {
  font-weight: normal;
  font-style: normal;
}
caption, th {
  text-align: left;
}
h1, h2, h3, h4, h5, h6 {
  font-weight: normal;
  font-size: 100%;
}
q:before, q:after {
  content: '';
}
abbr, acronym {
  border: 0;
}
.clearfix{
  *zoom: 1;
}
.clearfix:after, .clearfix:before{
  content: ' ';
  display: table;
  line-height: 0;
}
.clearfix:after{
  clear: both;
}
th, td{
  word-break: break-all;
}

body{
  padding:0px;
  width: 100%;
}
</style>
<body>
<div style="margin:15px;">
  <div> <p style="font-size:18px;"><b><?php echo htmlspecialchars_decode($article_info['topic'])?></b></p> </div>
  <hr style="height:1px;border:0;background-color:#e6e6e6;"/>
  <div style="font-size:15px;color:#999999;">
   <p style="display:inline;"><?php echo date("Y-m-d", $article_info['c_time'])?></p>
   <p style="margin-left:40px;display:inline"><?php echo $article_info['author']?></p>
  </div>
  <div style="margin-top:20px;"><?php echo htmlspecialchars_decode($article_info['content'])?></div>
  <br/>
</div>
</body>
</head></html>
