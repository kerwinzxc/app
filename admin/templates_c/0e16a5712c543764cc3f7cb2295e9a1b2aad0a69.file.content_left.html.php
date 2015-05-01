<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-05-01 18:49:40
         compiled from "D:\web\ddky\app2\admin\templates\content_left.html" */ ?>
<?php /*%%SmartyHeaderCode:2598655435a44b06526-67779167%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e16a5712c543764cc3f7cb2295e9a1b2aad0a69' => 
    array (
      0 => 'D:\\web\\ddky\\app2\\admin\\templates\\content_left.html',
      1 => 1430474285,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2598655435a44b06526-67779167',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    's_menu_func_g' => 0,
    's_doctor_lu_ru' => 0,
    's_doctor_cha_xun' => 0,
    's_my_doctor' => 0,
    's_menu_setting_g' => 0,
    's_xi_tong_she_zhi' => 0,
    's_ge_ren_she_zhi' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_55435a44b2f859_05610275',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55435a44b2f859_05610275')) {function content_55435a44b2f859_05610275($_smarty_tpl) {?><div id='content-left'>
  <div class="menu">
    <div class="menu_g">
      <div class="menu_h"><?php echo $_smarty_tpl->tpl_vars['s_menu_func_g']->value;?>
</div>
      <div class="menu_m"><a class="menu_a" href="view/doctor_entering.php"><?php echo $_smarty_tpl->tpl_vars['s_doctor_lu_ru']->value;?>
</a></div>
      <div class="menu_m"><a class="menu_a" href="view/doctor_query.php"><?php echo $_smarty_tpl->tpl_vars['s_doctor_cha_xun']->value;?>
</a></div>
      <div class="menu_m"><a class="menu_a" href="view/my_doctor.php"><?php echo $_smarty_tpl->tpl_vars['s_my_doctor']->value;?>
</a></div>
    </div>
    <div class="menu_g">
      <div class="menu_h"><?php echo $_smarty_tpl->tpl_vars['s_menu_setting_g']->value;?>
</div>
      <div class="menu_m"><a class="menu_a" href="view/my_settings.php"><?php echo $_smarty_tpl->tpl_vars['s_xi_tong_she_zhi']->value;?>
</a></div>
      <div class="menu_m"><a class="menu_a" href="view/my_settings.php"><?php echo $_smarty_tpl->tpl_vars['s_ge_ren_she_zhi']->value;?>
</a></div>
    </div>
  </div>
</div>
<?php }} ?>
