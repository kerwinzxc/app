<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-05-01 18:49:40
         compiled from "D:\web\ddky\app2\admin\templates\home.html" */ ?>
<?php /*%%SmartyHeaderCode:2006855435a44a31a42-90393970%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd32fb1e74a41266f3b1db6bced9eb70fd087a40c' => 
    array (
      0 => 'D:\\web\\ddky\\app2\\admin\\templates\\home.html',
      1 => 1430474285,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2006855435a44a31a42-90393970',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'h_inc_name' => 0,
    'base_url' => 0,
    'user_id' => 0,
    'inc_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_55435a44ac1687_28256270',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55435a44ac1687_28256270')) {function content_55435a44ac1687_28256270($_smarty_tpl) {?><html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php if (isset($_smarty_tpl->tpl_vars['h_inc_name']->value)) {?>
      <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['h_inc_name']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php }?>
  </head>
  <body>
    <div id='main'>
      <div id='header' class="clearfix">
      <p style='display:inline;font-size:35px;font-weight:bold;float: left;padding-top:28px;'><a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
" >滴滴快医-管理系统</a></p>
      <p style='float:right;padding-top:55px;'><?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
<a style="padding-left:10px;" href="logout.php">退出</a></p>
      </div>
      <div id='content' class="clearfix">
        <?php echo $_smarty_tpl->getSubTemplate ("content_left.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <?php echo $_smarty_tpl->getSubTemplate ("content_main.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('inc_name'=>$_smarty_tpl->tpl_vars['inc_name']->value), 0);?>

      </div>
      <?php echo $_smarty_tpl->getSubTemplate ("foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    </div>
  </body>
</html>
<?php }} ?>
