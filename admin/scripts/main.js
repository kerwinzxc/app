
// for check id card
var Wi = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1 ];
var ValideCode = [ 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ];
function IdCardValidate(idCard) {
  idCard = myTrim(idCard.replace(/ /g, ""));
  if (idCard.length == 15) {
    return isValidityBrithBy15IdCard(idCard);
  } else if (idCard.length == 18) {
    var a_idCard = idCard.split("");
    if(isValidityBrithBy18IdCard(idCard)&&isTrueValidateCodeBy18IdCard(a_idCard)){
      return true;
    }
  }
  return false;
}
function isTrueValidateCodeBy18IdCard(a_idCard) {
  var sum = 0;
  if (a_idCard[17].toLowerCase() == 'x') {
    a_idCard[17] = 10;
  }
  for ( var i = 0; i < 17; i++) {
    sum += Wi[i] * a_idCard[i];
  }
  valCodePosition = sum % 11;
  if (a_idCard[17] == ValideCode[valCodePosition]) {
    return true;
  } else {
    return false;
  }
}
function isValidityBrithBy18IdCard(idCard18){
  var year =  idCard18.substring(6,10);
  var month = idCard18.substring(10,12);
  var day = idCard18.substring(12,14);
  var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));
  if(temp_date.getFullYear()!=parseFloat(year)
     ||temp_date.getMonth()!=parseFloat(month)-1
     ||temp_date.getDate()!=parseFloat(day)){
    return false;
  } else {
    return true;
  }
}
function isValidityBrithBy15IdCard(idCard15){
  var year =  idCard15.substring(6,8);
  var month = idCard15.substring(8,10);
  var day = idCard15.substring(10,12);
  var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));
  if(temp_date.getYear()!=parseFloat(year)
     ||temp_date.getMonth()!=parseFloat(month)-1
     ||temp_date.getDate()!=parseFloat(day)){
    return false;
  } else {
    return true;
  }
}
function myTrim(str) {   
  return str.replace(/(^\s*)|(\s*$)/g, "");   
}
// end

function getStrLen(str) {
  var realLength = 0;
  var len = str.length;
  var charCode = -1;
  for(var i = 0; i < len; i++){
    charCode = str.charCodeAt(i);
    if (charCode >= 0 && charCode <= 128) {
      realLength += 1;
    } else {
      realLength += 3;
    }
  }
  return realLength; 
}

// check
function checkRegUser(obj) {
  var reg = /^[a-z\d_]{3,20}$/i;
  if (!reg.test(obj.value)) {
    alert('用户名不合法');
    return false;
  }
  return true;
}
function checkDoctorName(obj) {
  if (obj.value.length == 0) {
    alert('请输医生姓名!');
    return false;
  }
  if (getStrLen(obj.value) < 6 || getStrLen(obj.value) > 18) {
    alert('姓名长度不符合要求!');
    return false;
  }
  return true;
}
function checkPhoneNum(obj)
{
  if (obj.value.length == 0)
  {
    alert('请输入手机号!');
    return false;
  }
  var reg = /^0?1[3|4|5|8|7][0-9]\d{8}$/;
  if (obj.value.length != 11
      || !reg.test(obj.value))
  {
    alert('请输入正确的手机号!');
    return false;
  }
  return true;
}
function checkSex(obj)
{
  if (obj.value.length == 0) {
    alert('请选择性别!');
    return false;
  }
  return true;
}
function checkIdCard(obj)
{
  return true;
  if (obj.value.length == 0)
  {
    alert('请输入身份证号!');
    return false;
  }
  if (!IdCardValidate(obj.value))
  {
    alert('身份证号无效');
    return false;
  }
  return true;
}
function checkHospital(obj)
{
  if (obj.value.length == 0) {
    alert('请输入所属医院!');
    return false;
  }
  if (getStrLen(obj.value) >= 90) {
    alert('所属医院名称太长');
    return false;
  }
  return true;
}
function submitDoctorValidate()
{
  if (!checkDoctorName(document.getElementById("name")))
    return false;
  if (!checkPhoneNum(document.getElementById("phone_num")))
    return false;
  if (!checkSex(document.getElementById("sex")))
    return false;
  if (document.getElementById("classify").value.length == 0) {
    alert('请选择医生类别!');
    return false;
  }
  if (!checkHospital(document.getElementById("hospital")))
    return false;
  if (document.getElementById("ke_shi").value.length == 0) {
    alert('请选择科室!');
    return false;
  }
  if (document.getElementById("tec_title").value.length == 0) {
    alert('请选择技术职称!');
    return false;
  }
  if (document.getElementById("aca_title").value.length == 0) {
    alert('请选择学术职称!');
    return false;
  }
  return true;
}
function submitLoginValidate()
{
  if (!checkRegUser(document.getElementById("user")))
    return false;
  return true;
}
function clrDoctorQueryDefaultVal()
{
  var allEmpty = true;
  var defaultVal = document.getElementById("q_name");
  if (defaultVal.value == '医生姓名') defaultVal.value = '';
  if (defaultVal.value != '') allEmpty = false;

  defaultVal = document.getElementById("q_phone_num");
  if (defaultVal.value == '电话') defaultVal.value = '';
  if (defaultVal.value != '') allEmpty = false;

  defaultVal = document.getElementById("q_employe_id");
  if (defaultVal.value == '录入者ID') defaultVal.value = '';
  if (defaultVal.value != '') allEmpty = false;

  defaultVal = document.getElementById("q_classify");
  if (defaultVal.value != '') allEmpty = false;

  return !allEmpty;
}
function clrSPQueryDefaultVal()
{
  var allEmpty = true;
  var defaultVal = document.getElementById("q_linkman");
  if (defaultVal.value == '联系人') defaultVal.value = '';
  if (defaultVal.value != '') allEmpty = false;
  defaultVal = document.getElementById("q_phone_num");
  if (defaultVal.value == '联系电话') defaultVal.value = '';
  if (defaultVal.value != '') allEmpty = false;
  defaultVal = document.getElementById("q_employe_id");
  if (defaultVal.value == '录入者ID') defaultVal.value = '';
  if (defaultVal.value != '') allEmpty = false;
  return !allEmpty;
}
function onQueryInputFocus(obj, defaultVal)
{
  if (obj.value == defaultVal)
  {
    obj.value = "";
    obj.style.color = "#000";
  }
}
function onQueryInputBlur(obj, defaultVal)
{
  if (obj.value == '')
  {
    obj.value = defaultVal;
    obj.style.color = "#999";
  }
}
