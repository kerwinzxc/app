<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-05-01 18:49:40
         compiled from "D:\web\ddky\app2\admin\templates\doctor_info.html" */ ?>
<?php /*%%SmartyHeaderCode:2785655435a44b68189-28928232%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '132cf611fa3bca9b2305e97256761ad5a34632dd' => 
    array (
      0 => 'D:\\web\\ddky\\app2\\admin\\templates\\doctor_info.html',
      1 => 1430474285,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2785655435a44b68189-28928232',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'doctor_info_title' => 0,
    'master_name' => 0,
    'master_id' => 0,
    'new_one' => 0,
    'c_time' => 0,
    'id' => 0,
    'name' => 0,
    'phone_num' => 0,
    'sex' => 0,
    'classify' => 0,
    'hospital' => 0,
    'adm_title' => 0,
    'ke_shi' => 0,
    'tec_title' => 0,
    'aca_title' => 0,
    'expert_in' => 0,
    'icon_url' => 0,
    'readonly' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_55435a45af1e34_47649625',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55435a45af1e34_47649625')) {function content_55435a45af1e34_47649625($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\web\\ddky\\app2\\admin\\libs\\smarty\\libs\\plugins\\modifier.date_format.php';
?><div style="margin:35px 130px 0 130px;">
  <div>
    <p style="font-size:23px;display:inline"><?php echo $_smarty_tpl->tpl_vars['doctor_info_title']->value;?>
</p>
    <?php if (isset($_smarty_tpl->tpl_vars['master_name']->value)) {?>
    <p style="padding-left:15px;font-size:16px;display:inline">所属专家--<a href='view/doctor_modify.php?id=<?php echo $_smarty_tpl->tpl_vars['master_id']->value;?>
'><font color="#FF0000"><?php echo $_smarty_tpl->tpl_vars['master_name']->value;?>
</font></a></p>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['new_one']->value!=1) {?>
    <p style="font-size:16px;line-height:38px;float:right;">录入时间：<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['c_time']->value,"%Y-%m-%d %H:%M:%S");?>
</p>
    <?php }?>
    <hr style="height:2px;border:0;background-color:#FF9900;"/>
  </div>
  <div class="input_form">
    <form action=<?php if ($_smarty_tpl->tpl_vars['new_one']->value==1) {?>"view/doctor_entering.php"<?php } else { ?>"view/doctor_modify.php"<?php }?> method="post" enctype="multipart/form-data" onsubmit="return submitDoctorValidate()">
      <table>
        <tr><td><input type='hidden' name='master_id' value='<?php if (isset($_smarty_tpl->tpl_vars['master_id']->value)) {
echo $_smarty_tpl->tpl_vars['master_id']->value;
}?>'/></td></tr>
        <tr><td><input type='hidden' name='id' value='<?php if (isset($_smarty_tpl->tpl_vars['id']->value)) {
echo $_smarty_tpl->tpl_vars['id']->value;
}?>'/></td></tr>
        <tr>
          <td class="form_label">姓名</td>
          <td><input style="width:100px;padding-left:2px;" id='name' type='text' name='name' value='<?php if (isset($_smarty_tpl->tpl_vars['name']->value)) {
echo $_smarty_tpl->tpl_vars['name']->value;
}?>' onchange='checkDoctorName(this)'/><p class='must_p'>*</p></td>
        </tr>
        <tr>
          <td class="form_label">手机</td>
          <td><input style="width:150px;padding-left:2px;" id='phone_num' type='text' name='phone_num' value='<?php if (isset($_smarty_tpl->tpl_vars['phone_num']->value)) {
echo $_smarty_tpl->tpl_vars['phone_num']->value;
}?>' onchange='checkPhoneNum(this)'/><p class='must_p'>*</p></td>
        </tr>
        <tr><td class="form_label">性别</td>
          <td>
          <select style="width:60px;" id='sex' name='sex'>
          <option value="" >选择</option>
          <option value="0" <?php if (isset($_smarty_tpl->tpl_vars['sex']->value)&&$_smarty_tpl->tpl_vars['sex']->value==0) {?> selected="selected"<?php }?>>女</option>
          <option value="1" <?php if (isset($_smarty_tpl->tpl_vars['sex']->value)&&$_smarty_tpl->tpl_vars['sex']->value==1) {?> selected="selected"<?php }?>>男</option>
          </select><p class='must_p'>*</p>
          </td>
        </tr>
      </table>
      <hr style="margin-top:20px;height:1px;border:0;background-color:#FF9900;"/>
      <table>
        <tr><td class="form_label">医生类别</td>
          <td>
          <select style="display:inline;width:100px;" id='classify' name='classify'>
          <option value=""  >--医生类别--</option>
          <option value="1" <?php if (isset($_smarty_tpl->tpl_vars['classify']->value)&&$_smarty_tpl->tpl_vars['classify']->value==1) {?> selected="selected"<?php }?>>普通医生</option>
         <?php if (!isset($_smarty_tpl->tpl_vars['master_name']->value)) {?>
          <option value="2" <?php if (isset($_smarty_tpl->tpl_vars['classify']->value)&&$_smarty_tpl->tpl_vars['classify']->value==2) {?> selected="selected"<?php }?>>医学泰斗</option>
         <?php }?>
          </select>
          <p class='must_p' style='font-size:14px;'>* &nbsp;(内部定义类别)</p></td>
        </tr>
        <tr>
          <td class="form_label">所属医院</td>
          <td><input style="width:180px;padding-left:2px;float:left;" id='hospital' type='text' name='hospital' value='<?php if (isset($_smarty_tpl->tpl_vars['hospital']->value)) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['hospital']->value, ENT_QUOTES, 'UTF-8', true);
}?>' onchange='checkHospital(this)'/><p class='must_p'>*</p>
          <select style="width:95px;margin-left:10px;display:inline;" id=adm_title' name='adm_title'>
          <option value="" >--行政职称--</option>
          <option value="1" <?php if (isset($_smarty_tpl->tpl_vars['adm_title']->value)&&$_smarty_tpl->tpl_vars['adm_title']->value==1) {?> selected="selected"<?php }?>>院长</option>
          <option value="2" <?php if (isset($_smarty_tpl->tpl_vars['adm_title']->value)&&$_smarty_tpl->tpl_vars['adm_title']->value==2) {?> selected="selected"<?php }?>>副院长</option>
          </td>
        </tr>
        <tr><td class="form_label">科室</td>
          <td>
          <select style="display:inline;float:left;width:100px;" id='ke_shi' name='ke_shi'>
          <option value=""  >--选择科室-</option>
          <option value="1010" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1010) {?> selected="selected"<?php }?>>心血管内科</option>
          <option value="1011" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1011) {?> selected="selected"<?php }?>>神经内科</option>
          <option value="1012" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1012) {?> selected="selected"<?php }?>>消化内科</option>
          <option value="1013" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1013) {?> selected="selected"<?php }?>>内分泌科</option>
          <option value="1014" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1014) {?> selected="selected"<?php }?>>免疫科</option>
          <option value="1015" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1015) {?> selected="selected"<?php }?>>呼吸科</option>
          <option value="1016" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1016) {?> selected="selected"<?php }?>>肾病内科</option>
          <option value="1017" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1017) {?> selected="selected"<?php }?>>血液科</option>
          <option value="1018" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1018) {?> selected="selected"<?php }?>>感染内科</option>
          <option value="1019" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1019) {?> selected="selected"<?php }?>>过敏反应科</option>
          <option value="1020" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1020) {?> selected="selected"<?php }?>>老年病科</option>
          <option value="1021" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1021) {?> selected="selected"<?php }?>>疼痛诊疗科</option>
          <option value="1022" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1022) {?> selected="selected"<?php }?>>高压氧科</option>
          <option value="1023" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1023) {?> selected="selected"<?php }?>>普通科</option>
          <option value="1110" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1110) {?> selected="selected"<?php }?>>神经外科</option>
          <option value="1111" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1111) {?> selected="selected"<?php }?>>心血管外科</option>
          <option value="1112" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1112) {?> selected="selected"<?php }?>>腹部外科</option>
          <option value="1113" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1113) {?> selected="selected"<?php }?>>胸外科</option>
          <option value="1114" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1114) {?> selected="selected"<?php }?>>整形科</option>
          <option value="1115" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1115) {?> selected="selected"<?php }?>>乳腺外科</option>
          <option value="1116" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1116) {?> selected="selected"<?php }?>>泌尿外科</option>
          <option value="1117" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1117) {?> selected="selected"<?php }?>>肝胆外科</option>
          <option value="1118" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1118) {?> selected="selected"<?php }?>>肛肠科</option>
          <option value="1119" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1119) {?> selected="selected"<?php }?>>血管外科</option>
          <option value="1120" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1120) {?> selected="selected"<?php }?>>功能神经外科</option>
          <option value="1121" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1121) {?> selected="selected"<?php }?>>微创外科</option>
          <option value="1122" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1122) {?> selected="selected"<?php }?>>普外科</option>
          <option value="1210" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1210) {?> selected="selected"<?php }?>>妇科</option>
          <option value="1211" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1211) {?> selected="selected"<?php }?>>产科</option>
          <option value="1212" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1212) {?> selected="selected"<?php }?>>妇科内分泌</option>
          <option value="1213" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1213) {?> selected="selected"<?php }?>>妇泌尿科</option>
          <option value="1214" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1214) {?> selected="selected"<?php }?>>产前诊断科</option>
          <option value="1215" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1215) {?> selected="selected"<?php }?>>遗传咨询科</option>
          <option value="1216" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1216) {?> selected="selected"<?php }?>>计划生育科</option>
          <option value="1217" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1217) {?> selected="selected"<?php }?>>妇产科</option>
          <option value="1310" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1310) {?> selected="selected"<?php }?>>生殖中心</option>
          <option value="1410" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1410) {?> selected="selected"<?php }?>>儿科</option>
          <option value="1411" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1411) {?> selected="selected"<?php }?>>新生儿科</option>
          <option value="1412" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1412) {?> selected="selected"<?php }?>>小儿呼吸科</option>
          <option value="1413" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1413) {?> selected="selected"<?php }?>>小儿消化科</option>
          <option value="1414" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1414) {?> selected="selected"<?php }?>>小儿营养保健科</option>
          <option value="1415" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1415) {?> selected="selected"<?php }?>>小儿神经内科</option>
          <option value="1416" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1416) {?> selected="selected"<?php }?>>小儿心内科</option>
          <option value="1417" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1417) {?> selected="selected"<?php }?>>小儿肾内科</option>
          <option value="1418" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1418) {?> selected="selected"<?php }?>>小儿血液科</option>
          <option value="1419" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1419) {?> selected="selected"<?php }?>>小儿感染科</option>
          <option value="1420" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1420) {?> selected="selected"<?php }?>>小儿精神科</option>
          <option value="1421" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1421) {?> selected="selected"<?php }?>>小儿妇科</option>
          <option value="1422" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1422) {?> selected="selected"<?php }?>>小儿外科</option>
          <option value="1423" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1423) {?> selected="selected"<?php }?>>小儿心外科</option>
          <option value="1424" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1424) {?> selected="selected"<?php }?>>小儿胸外科</option>
          <option value="1425" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1425) {?> selected="selected"<?php }?>>小儿骨科</option>
          <option value="1426" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1426) {?> selected="selected"<?php }?>>小儿泌尿科</option>
          <option value="1427" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1427) {?> selected="selected"<?php }?>>小儿神经外科</option>
          <option value="1428" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1428) {?> selected="selected"<?php }?>>小儿整形科</option>
          <option value="1429" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1429) {?> selected="selected"<?php }?>>小儿康复科</option>
          <option value="1430" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1430) {?> selected="selected"<?php }?>>小儿急诊科</option>
          <option value="1510" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1510) {?> selected="selected"<?php }?>>骨科</option>
          <option value="1511" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1511) {?> selected="selected"<?php }?>>脊柱外科</option>
          <option value="1512" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1512) {?> selected="selected"<?php }?>>手外科</option>
          <option value="1513" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1513) {?> selected="selected"<?php }?>>创伤骨科</option>
          <option value="1514" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1514) {?> selected="selected"<?php }?>>骨关节科</option>
          <option value="1515" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1515) {?> selected="selected"<?php }?>>矫形骨科</option>
          <option value="1516" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1516) {?> selected="selected"<?php }?>>骨肿瘤科</option>
          <option value="1517" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1517) {?> selected="selected"<?php }?>>骨质疏松科</option>
          <option value="1518" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1518) {?> selected="selected"<?php }?>>足踝外科</option>
          <option value="1519" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1519) {?> selected="selected"<?php }?>>中西医结合正骨科</option>
          <option value="1610" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1610) {?> selected="selected"<?php }?>>眼肌</option>
          <option value="1611" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1611) {?> selected="selected"<?php }?>>眼科</option>
          <option value="1612" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1612) {?> selected="selected"<?php }?>>小儿眼科</option>
          <option value="1613" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1613) {?> selected="selected"<?php }?>>眼底</option>
          <option value="1614" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1614) {?> selected="selected"<?php }?>>角膜科</option>
          <option value="1615" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1615) {?> selected="selected"<?php }?>>青光眼</option>
          <option value="1616" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1616) {?> selected="selected"<?php }?>>白内障</option>
          <option value="1617" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1617) {?> selected="selected"<?php }?>>眼外科</option>
          <option value="1618" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1618) {?> selected="selected"<?php }?>>眼眶及肿瘤</option>
          <option value="1619" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1619) {?> selected="selected"<?php }?>>屈光</option>
          <option value="1620" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1620) {?> selected="selected"<?php }?>>眼整形</option>
          <option value="1621" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1621) {?> selected="selected"<?php }?>>中医眼科</option>
          <option value="1710" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1710) {?> selected="selected"<?php }?>>口腔科</option>
          <option value="1711" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1711) {?> selected="selected"<?php }?>>颌面外科</option>
          <option value="1712" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1712) {?> selected="selected"<?php }?>>正畸科</option>
          <option value="1713" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1713) {?> selected="selected"<?php }?>>牙体牙髓科</option>
          <option value="1714" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1714) {?> selected="selected"<?php }?>>牙周科</option>
          <option value="1715" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1715) {?> selected="selected"<?php }?>>口腔黏膜科</option>
          <option value="1716" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1716) {?> selected="selected"<?php }?>>儿童口腔科</option>
          <option value="1717" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1717) {?> selected="selected"<?php }?>>口腔修复科</option>
          <option value="1718" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1718) {?> selected="selected"<?php }?>>种植科</option>
          <option value="1719" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1719) {?> selected="selected"<?php }?>>口腔预防科</option>
          <option value="1720" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1720) {?> selected="selected"<?php }?>>综合科</option>
          <option value="1721" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1721) {?> selected="selected"<?php }?>>口腔特诊科</option>
          <option value="1722" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1722) {?> selected="selected"<?php }?>>老年口腔病科</option>
          <option value="1723" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1723) {?> selected="selected"<?php }?>>口腔急诊科</option>
          <option value="1810" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1810) {?> selected="selected"<?php }?>>耳科</option>
          <option value="1811" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1811) {?> selected="selected"<?php }?>>鼻科</option>
          <option value="1812" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1812) {?> selected="selected"<?php }?>>咽喉科</option>
          <option value="1813" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1813) {?> selected="selected"<?php }?>>头颈外科</option>
          <option value="1814" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1814) {?> selected="selected"<?php }?>>耳鼻喉科</option>
          <option value="1910" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1910) {?> selected="selected"<?php }?>>肿瘤内科</option>
          <option value="1911" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1911) {?> selected="selected"<?php }?>>肿瘤外科</option>
          <option value="1912" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1912) {?> selected="selected"<?php }?>>肿瘤妇科</option>
          <option value="1913" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1913) {?> selected="selected"<?php }?>>放疗科</option>
          <option value="1914" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1914) {?> selected="selected"<?php }?>>骨肿瘤科</option>
          <option value="1915" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1915) {?> selected="selected"<?php }?>>肿瘤康复科</option>
          <option value="1916" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==1916) {?> selected="selected"<?php }?>>肿瘤综合科</option>
          <option value="2010" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2010) {?> selected="selected"<?php }?>>皮肤科</option>
          <option value="2011" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2011) {?> selected="selected"<?php }?>>性病科</option>
          <option value="2110" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2110) {?> selected="selected"<?php }?>>男科</option>
          <option value="2210" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2210) {?> selected="selected"<?php }?>>皮肤美容</option>
          <option value="2310" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2310) {?> selected="selected"<?php }?>>烧伤科</option>
          <option value="2410" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2410) {?> selected="selected"<?php }?>>精神科</option>
          <option value="2411" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2411) {?> selected="selected"<?php }?>>心理咨询科</option>
          <option value="2412" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2412) {?> selected="selected"<?php }?>>司法鉴定科</option>
          <option value="2413" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2413) {?> selected="selected"<?php }?>>药物依赖科</option>
          <option value="2510" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2510) {?> selected="selected"<?php }?>>中医妇产科</option>
          <option value="2511" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2511) {?> selected="selected"<?php }?>>中医儿科</option>
          <option value="2512" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2512) {?> selected="selected"<?php }?>>中医骨科</option>
          <option value="2513" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2513) {?> selected="selected"<?php }?>>中医皮肤科</option>
          <option value="2514" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2514) {?> selected="selected"<?php }?>>中医内分泌</option>
          <option value="2515" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2515) {?> selected="selected"<?php }?>>中医消化科</option>
          <option value="2516" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2516) {?> selected="selected"<?php }?>>中医呼吸科</option>
          <option value="2517" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2517) {?> selected="selected"<?php }?>>中医肾病内科</option>
          <option value="2518" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2518) {?> selected="selected"<?php }?>>中医免疫科</option>
          <option value="2519" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2519) {?> selected="selected"<?php }?>>中医心内科</option>
          <option value="2520" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2520) {?> selected="selected"<?php }?>>中医神经内科</option>
          <option value="2521" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2521) {?> selected="selected"<?php }?>>中医肿瘤科</option>
          <option value="2522" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2522) {?> selected="selected"<?php }?>>中医血液科</option>
          <option value="2523" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2523) {?> selected="selected"<?php }?>>中医感染内科</option>
          <option value="2524" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2524) {?> selected="selected"<?php }?>>中医肝病科</option>
          <option value="2525" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2525) {?> selected="selected"<?php }?>>中医五官科</option>
          <option value="2526" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2526) {?> selected="selected"<?php }?>>中医男科</option>
          <option value="2527" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2527) {?> selected="selected"<?php }?>>针灸科</option>
          <option value="2528" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2528) {?> selected="selected"<?php }?>>中医按摩科</option>
          <option value="2529" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2529) {?> selected="selected"<?php }?>>中医外科</option>
          <option value="2530" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2530) {?> selected="selected"<?php }?>>中医乳腺外科</option>
          <option value="2531" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2531) {?> selected="selected"<?php }?>>中医肝肠科</option>
          <option value="2532" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2532) {?> selected="selected"<?php }?>>中医老年病科</option>
          <option value="2533" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2533) {?> selected="selected"<?php }?>>中医理疗科</option>
          <option value="2534" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2534) {?> selected="selected"<?php }?>>中医正骨科</option>
          <option value="2535" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2535) {?> selected="selected"<?php }?>>中医科</option>
          <option value="2610" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2610) {?> selected="selected"<?php }?>>中西医结合科</option>
          <option value="2710" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2710) {?> selected="selected"<?php }?>>肝病科</option>
          <option value="2711" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2711) {?> selected="selected"<?php }?>>传染科</option>
          <option value="2712" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2712) {?> selected="selected"<?php }?>>艾滋病科</option>
          <option value="2713" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2713) {?> selected="selected"<?php }?>>传染危重室</option>
          <option value="2810" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2810) {?> selected="selected"<?php }?>>结核病科</option>
          <option value="2910" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==2910) {?> selected="selected"<?php }?>>介入医学科</option>
          <option value="3010" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3010) {?> selected="selected"<?php }?>>康复科</option>
          <option value="3011" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3011) {?> selected="selected"<?php }?>>理疗科</option>
          <option value="3110" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3110) {?> selected="selected"<?php }?>>运动医学科</option>
          <option value="3210" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3210) {?> selected="selected"<?php }?>>疼痛科</option>
          <option value="3011" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3011) {?> selected="selected"<?php }?>>麻醉科</option>
          <option value="3310" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3310) {?> selected="selected"<?php }?>>职业病科</option>
          <option value="3410" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3410) {?> selected="selected"<?php }?>>地方病科</option>
          <option value="3510" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3510) {?> selected="selected"<?php }?>>营养科</option>
          <option value="3610" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3610) {?> selected="selected"<?php }?>>医学影像科</option>
          <option value="3710" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3710) {?> selected="selected"<?php }?>>病理科</option>
          <option value="3810" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3810) {?> selected="selected"<?php }?>>急诊科</option>
          <option value="3811" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3811) {?> selected="selected"<?php }?>>预防保健科</option>
          <option value="3812" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3812) {?> selected="selected"<?php }?>>药剂科</option>
          <option value="3813" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3813) {?> selected="selected"<?php }?>>体检科</option>
          <option value="3814" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3814) {?> selected="selected"<?php }?>>血透中心</option>
          <option value="3815" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3815) {?> selected="selected"<?php }?>>碎石中心</option>
          <option value="3816" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3816) {?> selected="selected"<?php }?>>ICU</option>
          <option value="3817" <?php if (isset($_smarty_tpl->tpl_vars['ke_shi']->value)&&$_smarty_tpl->tpl_vars['ke_shi']->value==3817) {?> selected="selected"<?php }?>>护理咨询</option>
          </select>
          <p class='must_p'>*</p></td>
        </tr>
        <tr><td class="form_label">职称</td>
          <td>
          <select style="width:100px;display:inline;float:left;" id='tec_title' name='tec_title'>
          <option value=""  >--技术职称--</option>
          <option value="1" <?php if (isset($_smarty_tpl->tpl_vars['tec_title']->value)&&$_smarty_tpl->tpl_vars['tec_title']->value==1) {?> selected="selected"<?php }?>>主任医师</option>
          <option value="2" <?php if (isset($_smarty_tpl->tpl_vars['tec_title']->value)&&$_smarty_tpl->tpl_vars['tec_title']->value==2) {?> selected="selected"<?php }?>>副主任医师</option>
          <option value="3" <?php if (isset($_smarty_tpl->tpl_vars['tec_title']->value)&&$_smarty_tpl->tpl_vars['tec_title']->value==3) {?> selected="selected"<?php }?>>主治医师</option>
          <option value="4" <?php if (isset($_smarty_tpl->tpl_vars['tec_title']->value)&&$_smarty_tpl->tpl_vars['tec_title']->value==4) {?> selected="selected"<?php }?>>住院医师</option>
          </select> <p class='must_p'>*</p>
          <select style="width:100px;margin-left:20px;" id=aca_title' name='aca_title'>
          <option value=""  >--学术职称--</option>
          <option value="1" <?php if (isset($_smarty_tpl->tpl_vars['aca_title']->value)&&$_smarty_tpl->tpl_vars['aca_title']->value==1) {?> selected="selected"<?php }?>>教授</option>
          <option value="2" <?php if (isset($_smarty_tpl->tpl_vars['aca_title']->value)&&$_smarty_tpl->tpl_vars['aca_title']->value==2) {?> selected="selected"<?php }?>>副教授</option>
          </select> <p class='must_p'>*</p>
          </td>
        </tr>
        <tr>
          <td class="form_label">擅长</td>
          <td><textarea style="margin:5px 0px 5px 0px;padding:5px;width:310px;resize:none;" rows='6' cols='20' maxlength='300' name='expert_in'><?php if (isset($_smarty_tpl->tpl_vars['expert_in']->value)) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['expert_in']->value, ENT_QUOTES, 'UTF-8', true);
}?></textarea></td>
        </tr>
        <tr>
          <td class="form_label">医生照片</td>
          <td class="upload"><input style='font-size:10px;color:#C00;' name='txt1' type="text" disabled="disabled" value='不能超2M (限定格式：jpg,png)'/><input type="button" value="浏览"/><input type="file" name='photo' onchange="txt1.value=this.value;"/></td>
        <?php if (!empty($_smarty_tpl->tpl_vars['icon_url']->value)) {?>
          <td style="padding-left:10px;"><a href='<?php echo $_smarty_tpl->tpl_vars['icon_url']->value;?>
' target='_blank'><img src='<?php echo $_smarty_tpl->tpl_vars['icon_url']->value;?>
' height="120" width="120"</img></a></td>
        <?php }?>
        </tr>
      </table>
      <hr style="margin-top:20px;height:1px;border:0;background-color:#FF9900;"/>
      <div class="submit">
        <input style="width:80px;margin-right:40px;" type='submit' value=<?php if ($_smarty_tpl->tpl_vars['new_one']->value==1) {?>'提交'<?php } else { ?>'修改'<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['readonly']->value)&&$_smarty_tpl->tpl_vars['readonly']->value==1) {?>disabled="disabled"<?php }?> }/>
        <input style="width:80px;" type='reset' value='取消' />
      </div>
    </form>
  </div>
</div>
<?php }} ?>
