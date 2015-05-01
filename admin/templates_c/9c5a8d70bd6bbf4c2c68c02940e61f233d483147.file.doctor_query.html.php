<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-05-01 19:40:48
         compiled from "D:\web\ddky\app2\admin\templates\doctor_query.html" */ ?>
<?php /*%%SmartyHeaderCode:3150555435a6c2c9f17-52392127%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c5a8d70bd6bbf4c2c68c02940e61f233d483147' => 
    array (
      0 => 'D:\\web\\ddky\\app2\\admin\\templates\\doctor_query.html',
      1 => 1430480232,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3150555435a6c2c9f17-52392127',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_55435a6cb98176_96641730',
  'variables' => 
  array (
    'my_doctor' => 0,
    'name' => 0,
    'phone_num' => 0,
    'classify' => 0,
    'employe_id' => 0,
    'doctor_rows' => 0,
    'row' => 0,
    'total_num' => 0,
    'page' => 0,
    'pages' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55435a6cb98176_96641730')) {function content_55435a6cb98176_96641730($_smarty_tpl) {?><?php echo '<script'; ?>
 type="text/javascript">
function loadFun() {
  var ulList = document.getElementsByTagName("ul");
  for (var i = 0; i < ulList.length; i++) {
    var liNodes = ulList[i].childNodes;
    for (var j = 0; j < liNodes.length; j++) {
      if (liNodes[j].tagName == 'LI') {
        liNodes[j].onmouseover=function() {
          this.className+=(this.className.length>0? " ": "") + "sfhover";
        }
        liNodes[j].onMouseDown=function() {
          this.className+=(this.className.length>0? " ": "") + "sfhover";
        }
        liNodes[j].onMouseUp=function() {
          this.className+=(this.className.length>0? " ": "") + "sfhover";
        }
        liNodes[j].onmouseout=function() {
          this.className=this.className.replace(new RegExp("( ?|^)sfhover\\b"), "");
        }
      }
    }
  }
}
window.onload = loadFun;
<?php echo '</script'; ?>
>

<div class="query" style="margin:8px;width: 829px \9;">
  <div style="width:100%;height:60px;margin-bottom:8px;background:#FFC78E;text-align:center;">
    <?php if (!isset($_smarty_tpl->tpl_vars['my_doctor']->value)) {?>
    <form method="get" action='view/doctor_query.php'>
    <?php } else { ?>
    <form method="get" action='view/my_doctor.php'>
    <?php }?>
    <input type='hidden' name='kw' value=''/>
      <input style="width:90px;padding-left:5px;" type='text' id='q_name' name='name' value='<?php if (isset($_smarty_tpl->tpl_vars['name']->value)) {
echo $_smarty_tpl->tpl_vars['name']->value;
} else { ?>医生姓名<?php }?>' onfocus='onQueryInputFocus(this,"医生姓名")' onblur='onQueryInputBlur(this,"医生姓名")'/>
      <input style="width:100px;padding-left:5px;" type='text' id='q_phone_num' name='phone_num' value='<?php if (isset($_smarty_tpl->tpl_vars['phone_num']->value)) {
echo $_smarty_tpl->tpl_vars['phone_num']->value;
} else { ?>电话<?php }?>' onchange='checkPhoneNum(this)' onfocus='onQueryInputFocus(this,"电话")' onblur='onQueryInputBlur(this,"电话")'/>
      <select style="width:100px;padding-left:2px;" id='q_classify' name='classify'>
        <option value=""  >--医生类别--</option>
        <option value="1" <?php if (isset($_smarty_tpl->tpl_vars['classify']->value)&&$_smarty_tpl->tpl_vars['classify']->value==1) {?> selected="selected"<?php }?>>普通医生</option>
        <option value="2" <?php if (isset($_smarty_tpl->tpl_vars['classify']->value)&&$_smarty_tpl->tpl_vars['classify']->value==2) {?> selected="selected"<?php }?>>医学泰斗</option>
      </select>
      <?php if (!isset($_smarty_tpl->tpl_vars['my_doctor']->value)) {?>
      <input style="width:100px;padding-left:5px;" type='text' id='q_employe_id' name='employe_id' value='<?php if (isset($_smarty_tpl->tpl_vars['employe_id']->value)) {
echo $_smarty_tpl->tpl_vars['employe_id']->value;
} else { ?>录入者ID<?php }?>' onfocus='onQueryInputFocus(this,"录入者ID")' onblur='onQueryInputBlur(this,"录入者ID")'/>
      <?php }?>
      <input style='width:60px;margin-left:30px;' type='submit' value='查询' onclick='return clrDoctorQueryDefaultVal();'/>
    </form>
  </div>
  <table style="width:100%;table-layout:fixed;">
    <tr style="font-weight:bold;">
      <th style="width:12%;height:44px;background:#E9893A;">医生姓名</th>
      <th style="width:13%;background:#E9893A;">电话</th>
      <th style="width:12%;background:#E9893A;">类别</th>
      <th style="width:18%;background:#E9893A;">职称</th>
      <th style="width:20%;background:#E9893A;">所属医院</th>
      <th style="width:15%;background:#E9893A;">科室</th>
      <th style="width:10%;background:#E9893A;">操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['doctor_rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
      <tr>
        <td style="height:36px;"><a href='view/doctor_modify.php?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
'><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</a></td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['phone_num'];?>
</td>
        <td>
          <?php if ($_smarty_tpl->tpl_vars['row']->value['classify']==1) {?>普通医生
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['classify']==2) {?>医学泰斗
          <?php } else { ?>未知
          <?php }?>
        </td>
        <td><?php if ($_smarty_tpl->tpl_vars['row']->value['tec_title']==1) {?>主任医师,
<?php } elseif ($_smarty_tpl->tpl_vars['row']->value['tec_title']==2) {?>副主任医师,
<?php } elseif ($_smarty_tpl->tpl_vars['row']->value['tec_title']==3) {?>主治医师,
<?php } elseif ($_smarty_tpl->tpl_vars['row']->value['tec_title']==4) {?>住院医师,
<?php } else { ?>未填
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['row']->value['aca_title']==1) {?>教授
<?php } elseif ($_smarty_tpl->tpl_vars['row']->value['aca_title']==2) {?>副教授
<?php } else { ?>未填
<?php }?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['hospital'];?>
</td>
        <td>
          <?php if ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1010) {?>心血管内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1011) {?>神经内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1012) {?>消化内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1013) {?>内分泌科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1014) {?>免疫科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1015) {?>呼吸科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1016) {?>肾病内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1017) {?>血液科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1018) {?>感染内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1019) {?>过敏反应科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1020) {?>老年病科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1021) {?>疼痛诊疗科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1022) {?>高压氧科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1023) {?>普通科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1110) {?>神经外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1111) {?>心血管外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1112) {?>腹部外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1113) {?>胸外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1114) {?>整形科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1115) {?>乳腺外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1116) {?>泌尿外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1117) {?>肝胆外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1118) {?>肛肠科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1119) {?>血管外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1120) {?>功能神经外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1121) {?>微创外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1122) {?>普外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1210) {?>妇科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1211) {?>产科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1212) {?>妇科内分泌
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1213) {?>妇泌尿科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1214) {?>产前诊断科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1215) {?>遗传咨询科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1216) {?>计划生育科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1217) {?>妇产科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1310) {?>生殖中心
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1410) {?>儿科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1411) {?>新生儿科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1412) {?>小儿呼吸科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1413) {?>小儿消化科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1414) {?>小儿营养保健科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1415) {?>小儿神经内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1416) {?>小儿心内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1417) {?>小儿肾内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1418) {?>小儿血液科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1419) {?>小儿感染科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1420) {?>小儿精神科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1421) {?>小儿妇科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1422) {?>小儿外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1423) {?>小儿心外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1424) {?>小儿胸外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1425) {?>小儿骨科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1426) {?>小儿泌尿科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1427) {?>小儿神经外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1428) {?>小儿整形科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1429) {?>小儿康复科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1430) {?>小儿急诊科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1510) {?>骨科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1511) {?>脊柱外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1512) {?>手外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1513) {?>创伤骨科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1514) {?>骨关节科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1515) {?>矫形骨科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1516) {?>骨肿瘤科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1517) {?>骨质疏松科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1518) {?>足踝外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1519) {?>中西医结合正骨科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1610) {?>眼肌
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1611) {?>眼科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1612) {?>小儿眼科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1613) {?>眼底
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1614) {?>角膜科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1615) {?>青光眼
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1616) {?>白内障
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1617) {?>眼外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1618) {?>眼眶及肿瘤
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1619) {?>屈光
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1620) {?>眼整形
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1621) {?>中医眼科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1710) {?>口腔科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1711) {?>颌面外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1712) {?>正畸科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1713) {?>牙体牙髓科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1714) {?>牙周科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1715) {?>口腔黏膜科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1716) {?>儿童口腔科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1717) {?>口腔修复科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1718) {?>种植科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1719) {?>口腔预防科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1720) {?>综合科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1721) {?>口腔特诊科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1722) {?>老年口腔病科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1723) {?>口腔急诊科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1810) {?>耳科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1811) {?>鼻科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1812) {?>咽喉科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1813) {?>头颈外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1814) {?>耳鼻喉科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1910) {?>肿瘤内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1911) {?>肿瘤外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1912) {?>肿瘤妇科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1913) {?>放疗科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1914) {?>骨肿瘤科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1915) {?>肿瘤康复科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==1916) {?>肿瘤综合科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2010) {?>皮肤科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2011) {?>性病科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2110) {?>男科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2210) {?>皮肤美容
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2310) {?>烧伤科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2410) {?>精神科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2411) {?>心理咨询科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2412) {?>司法鉴定科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2413) {?>药物依赖科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2510) {?>中医妇产科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2511) {?>中医儿科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2512) {?>中医骨科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2513) {?>中医皮肤科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2514) {?>中医内分泌
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2515) {?>中医消化科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2516) {?>中医呼吸科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2517) {?>中医肾病内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2518) {?>中医免疫科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2519) {?>中医心内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2520) {?>中医神经内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2521) {?>中医肿瘤科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2522) {?>中医血液科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2523) {?>中医感染内科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2524) {?>中医肝病科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2525) {?>中医五官科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2526) {?>中医男科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2527) {?>针灸科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2528) {?>中医按摩科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2529) {?>中医外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2530) {?>中医乳腺外科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2531) {?>中医肝肠科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2532) {?>中医老年病科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2533) {?>中医理疗科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2534) {?>中医正骨科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2535) {?>中医科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2610) {?>中西医结合科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2710) {?>肝病科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2711) {?>传染科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2712) {?>艾滋病科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2713) {?>传染危重室
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2810) {?>结核病科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==2910) {?>介入医学科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3010) {?>康复科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3011) {?>理疗科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3110) {?>运动医学科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3210) {?>疼痛科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3011) {?>麻醉科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3310) {?>职业病科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3410) {?>地方病科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3510) {?>营养科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3610) {?>医学影像科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3710) {?>病理科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3810) {?>急诊科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3811) {?>预防保健科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3812) {?>药剂科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3813) {?>体检科
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3814) {?>血透中心
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3815) {?>碎石中心
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3816) {?>ICU
          <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ke_shi']==3817) {?>护理咨询
          <?php } else { ?>未知
          <?php }?>
        </td>
        <td>
        <ul class="doctor_opt_menu">
        <li>
        <!-- <a href="view/doctor_modify.php?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">详细</a> -->
        <a href="#" onclick="return false;">操作</a>  
          <ul id="opt_menu">
            <li><a href="view/doctor_modify.php?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">查看详情</a></li>
            <li><a href="view/doctor_article_list.php?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">文章列表</a></li>
            <li><a href="view/add_doctor_article.php?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" target="_blank">添加文章</a></li>
            <li><a href="view/doctor_video_list.php?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">视频列表</a></li>
            <li><a href="view/add_doctor_video.php?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">添加视频</a></li>
            <?php if ($_smarty_tpl->tpl_vars['row']->value['classify']==2) {?>
            <li><a href="view/doctor_entering.php?master_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">添加下属</a></li>
            <li><a href="view/doctor_xiashu.php?master_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">下属列表</a></li>
            <?php }?>
          </ul>  
          </li>
        </ul>
        </td>
      </tr>
    <?php } ?>
  </table>
  <div class="page_v">
    <p style="display:inline">共<?php if (!isset($_smarty_tpl->tpl_vars['total_num']->value)) {?>0<?php } else {
echo $_smarty_tpl->tpl_vars['total_num']->value;
}?>名</p>
    <?php if (!isset($_smarty_tpl->tpl_vars['my_doctor']->value)) {?>
      <?php if (!isset($_smarty_tpl->tpl_vars['page']->value)||$_smarty_tpl->tpl_vars['page']->value==1) {?>上一页<?php } else { ?><a href="view/doctor_query.php?p=<?php echo $_smarty_tpl->tpl_vars['page']->value-1;?>
">上一页</a><?php }?>
      <?php if (!isset($_smarty_tpl->tpl_vars['page']->value)||$_smarty_tpl->tpl_vars['page']->value>=$_smarty_tpl->tpl_vars['pages']->value) {?>下一页<?php } else { ?><a href="view/doctor_query.php?p=<?php echo $_smarty_tpl->tpl_vars['page']->value+1;?>
">下一页</a><?php }?>
    <?php } else { ?>
      <?php if (!isset($_smarty_tpl->tpl_vars['page']->value)||$_smarty_tpl->tpl_vars['page']->value==1) {?>上一页<?php } else { ?><a href="view/my_doctor.php?p=<?php echo $_smarty_tpl->tpl_vars['page']->value-1;?>
">上一页</a><?php }?>
      <?php if (!isset($_smarty_tpl->tpl_vars['page']->value)||$_smarty_tpl->tpl_vars['page']->value>=$_smarty_tpl->tpl_vars['pages']->value) {?>下一页<?php } else { ?><a href="view/my_doctor.php?p=<?php echo $_smarty_tpl->tpl_vars['page']->value+1;?>
">下一页</a><?php }?>
    <?php }?>
  </div>
</div>
<?php }} ?>
