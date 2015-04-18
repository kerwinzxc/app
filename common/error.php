<?php

$ERRORS = array(0 => 'ok');

define('ERR_PARAM_INVALID', -1001);        $ERRORS[ERR_PARAM_INVALID] = 'params are invalid';
define('ERR_DB_ERROR', -1002);             $ERRORS[ERR_DB_ERROR] = 'inner error';
define('ERR_CACHE_CONNECT_FAIL', -1003);   $ERRORS[ERR_CACHE_CONNECT_FAIL] = 'inner error';
define('ERR_INNER_ERROR', -1004);          $ERRORS[ERR_INNER_ERROR] = 'inner error';

define('ERR_NOT_LOGIN', -1100);            $ERRORS[ERR_NOT_LOGIN] = 'not login';
define('ERR_USER_NOT_EXIST', -1101);       $ERRORS[ERR_USER_NOT_EXIST] = 'user not exist';
define('ERR_PASSWD_ERR', -1102);           $ERRORS[ERR_PASSWD_ERR] = 'passwd error';
define('ERR_USER_EXIST', -1103);           $ERRORS[ERR_USER_EXIST] = 'user exists';
define('ERR_USER_PATIENTS_LIMIT', -1104);  $ERRORS[ERR_USER_PATIENTS_LIMIT] = 'user patient out of limit';
define('ERR_USER_GZ_DOCTOR_LIMIT', -1105); $ERRORS[ERR_USER_GZ_DOCTOR_LIMIT] = 'user guan zhu doctor out of limit';
define('ERR_USER_GZ_DOCTOR_EXIST', -1106); $ERRORS[ERR_USER_GZ_DOCTOR_EXIST] = 'user had guan zhu';
define('ERR_ID_CARD_INVALID', -1107);      $ERRORS[ERR_ID_CARD_INVALID] = 'user id card error';
define('ERR_USER_GZ_KE_SHI_LIMIT', -1108); $ERRORS[ERR_USER_GZ_KE_SHI_LIMIT] = 'user guan zhu ke shi out of limit';
define('ERR_USER_GZ_KE_SHI_EXIST', -1109); $ERRORS[ERR_USER_GZ_KE_SHI_EXIST] = 'user had guan zhu';
define('ERR_USER_GZ_BA_LIMIT', -1110);     $ERRORS[ERR_USER_GZ_BA_LIMIT] = 'user guan zhu ba out of limit';
define('ERR_USER_GZ_BA_EXIST', -1111);     $ERRORS[ERR_USER_GZ_BA_EXIST] = 'user had guan zhu';
define('ERR_PHONE_NUM_HAD_REG', -1112);    $ERRORS[ERR_PHONE_NUM_HAD_REG] = '手机号码已经注册';
define('ERR_REG_SMS_TIME_LIMIT', -1113);   $ERRORS[ERR_REG_SMS_TIME_LIMIT] = '您已提交验证码请求，请稍候!';
define('ERR_REG_SMS_TODAY_LIMIT', -1114);  $ERRORS[ERR_REG_SMS_TODAY_LIMIT] = '您今日请求验证码次数太多，请明日再试!';
define('ERR_REG_SMS_FAILED', -1115);       $ERRORS[ERR_REG_SMS_FAILED] = '获取注册验证码失败，请稍后重试!';
define('ERR_OLD_PASSWD_ERROR', -1116);     $ERRORS[ERR_OLD_PASSWD_ERROR] = '原密码错误';
define('ERR_BA_TOPIC_NOT_EXIST', -1117);   $ERRORS[ERR_BA_TOPIC_NOT_EXIST] = '话题不存在';
define('ERR_PATIENT_EMR_NOT_EXIST', -1118);$ERRORS[ERR_PATIENT_EMR_NOT_EXIST] = '就诊人病历不存在';
define('ERR_DOCTOR_NOT_EXIST', -1119);     $ERRORS[ERR_DOCTOR_NOT_EXIST] = '医生不存在';
define('ERR_PATIENT_ID_CARD_EXIST', -1120); $ERRORS[ERR_PATIENT_ID_CARD_EXIST] = '就诊人身份证已经存在';
