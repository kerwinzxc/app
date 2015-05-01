<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-05-01 18:49:40
         compiled from "D:\web\ddky\app2\admin\templates\content_main.html" */ ?>
<?php /*%%SmartyHeaderCode:117155435a44b3dfe5-78412709%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2799ebb30d6e3cc768ac24940eb27e405ef20880' => 
    array (
      0 => 'D:\\web\\ddky\\app2\\admin\\templates\\content_main.html',
      1 => 1430474285,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '117155435a44b3dfe5-78412709',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'refer' => 0,
    'content_title' => 0,
    'inc_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_55435a44b57722_50563911',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55435a44b57722_50563911')) {function content_55435a44b57722_50563911($_smarty_tpl) {?><div id="content-main">
  <div id="content_title">
  <a style="display:inline;text-decoration: none;" href='<?php echo $_smarty_tpl->tpl_vars['refer']->value;?>
'>&lt;&lt;</a><p style="padding-left:20px;display:inline;"><?php echo $_smarty_tpl->tpl_vars['content_title']->value;?>
</p></div>
  <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['inc_name']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
<?php }} ?>
