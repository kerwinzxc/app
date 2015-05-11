<?php

$ERRORS = array(0 => 'ok');

define('ERR_PARAM_INVALID', 1001);          $ERRORS[ERR_PARAM_INVALID] = '参数错误';
define('ERR_DB_ERROR', 1002);               $ERRORS[ERR_DB_ERROR] = '系统内部错误';
define('ERR_CACHE_CONNECT_FAIL', 1003);     $ERRORS[ERR_CACHE_CONNECT_FAIL] = '系统内部错误';
define('ERR_INNER_ERROR', 1004);            $ERRORS[ERR_INNER_ERROR] = '系统内部错误';
define('ERR_NOT_LOGIN', 1100);              $ERRORS[ERR_NOT_LOGIN] = '您没有登陆，请登录';
define('ERR_USER_NOT_EXIST', 1101);         $ERRORS[ERR_USER_NOT_EXIST] = '用户不存在';
define('ERR_PASSWD_ERR', 1102);             $ERRORS[ERR_PASSWD_ERR] = '密码错误';
define('ERR_USER_EXIST', 1103);             $ERRORS[ERR_USER_EXIST] = '用户已经存在';
define('ERR_USER_PATIENTS_LIMIT', 1104);    $ERRORS[ERR_USER_PATIENTS_LIMIT] = '您的就诊人数量已经达到上限';
define('ERR_USER_GZ_DOCTOR_LIMIT', 1105);   $ERRORS[ERR_USER_GZ_DOCTOR_LIMIT] = '您的医生关注列表数量已经达到上限';
define('ERR_USER_GZ_DOCTOR_EXIST', 1106);   $ERRORS[ERR_USER_GZ_DOCTOR_EXIST] = '医生已经关注';
define('ERR_ID_CARD_INVALID', 1107);        $ERRORS[ERR_ID_CARD_INVALID] = '身份证号无效';
define('ERR_USER_GZ_KE_SHI_LIMIT', 1108);   $ERRORS[ERR_USER_GZ_KE_SHI_LIMIT] = '您关注科室数量已经达到上限';
define('ERR_USER_GZ_BA_LIMIT', 1109);       $ERRORS[ERR_USER_GZ_BA_LIMIT] = '您关注的话题吧已经达到上限';
define('ERR_BA_TOPIC_HAD_ZAN', 1110);       $ERRORS[ERR_BA_TOPIC_HAD_ZAN] = '您已赞过此话题';

define('ERR_SMS_ERROR', 1111);              $ERRORS[ERR_SMS_ERROR] = '验证错误，请重新获取';
define('ERR_PHONE_NUM_HAD_REG', 1112);      $ERRORS[ERR_PHONE_NUM_HAD_REG] = '手机号码已经注册';
define('ERR_REG_SMS_TIME_LIMIT', 1113);     $ERRORS[ERR_REG_SMS_TIME_LIMIT] = '您已提交验证码请求，请稍候!';
define('ERR_REG_SMS_TODAY_LIMIT', 1114);    $ERRORS[ERR_REG_SMS_TODAY_LIMIT] = '您今日请求验证码次数太多，请明日再试!';
define('ERR_REG_SMS_FAILED', 1115);         $ERRORS[ERR_REG_SMS_FAILED] = '获取注册验证码失败，请稍后重试!';
define('ERR_OLD_PASSWD_ERROR', 1116);       $ERRORS[ERR_OLD_PASSWD_ERROR] = '原密码错误';
define('ERR_BA_TOPIC_NOT_EXIST', 1117);     $ERRORS[ERR_BA_TOPIC_NOT_EXIST] = '话题不存在';
define('ERR_PATIENT_EMR_NOT_EXIST', 1118);  $ERRORS[ERR_PATIENT_EMR_NOT_EXIST] = '就诊人病历不存在';
define('ERR_DOCTOR_NOT_EXIST', 1119);       $ERRORS[ERR_DOCTOR_NOT_EXIST] = '医生不存在';
define('ERR_PATIENT_ID_CARD_EXIST', 1120);  $ERRORS[ERR_PATIENT_ID_CARD_EXIST] = '就诊人身份证已经存在';
define('ERR_BA_TOPIC_HAD_NOT_ZAN', 1121);   $ERRORS[ERR_BA_TOPIC_HAD_NOT_ZAN] = '您还没有赞过此话题';
define('ERR_BA_TOPIC_TOO_LONG', 1122);      $ERRORS[ERR_BA_TOPIC_TOO_LONG] = '标题太长(不能超过30个汉字)';
define('ERR_BA_TOPIC_CONTENT_TOO_LONG', 1123);$ERRORS[ERR_BA_TOPIC_CONTENT_TOO_LONG] = '话题内容太长(最多可发表4000个汉字)';
define('ERR_BA_TOPIC_COMMENT_TOO_LONG', 1124);$ERRORS[ERR_BA_TOPIC_COMMENT_TOO_LONG] = '评论内容太长(最多可发表4000个汉字)';
define('ERR_UPLOAD_ICON_SIZE_LIMIT', 1125); $ERRORS[ERR_UPLOAD_ICON_SIZE_LIMIT] = '上传头像大小超出限制(不能超过2M)';
define('ERR_UPLOAD_ICON_TYPE_INVALID', 1126);$ERRORS[ERR_UPLOAD_ICON_TYPE_INVALID] = '上传头像图片格式不支持(仅支持jpg/jpeg/png)';
define('ERR_UPLOAD_ICON_ERROR', 1127);      $ERRORS[ERR_UPLOAD_ICON_ERROR] = '头像上传出现错误，请重试';
define('ERR_UPLOAD_ICON_MV_FAILED', 1128);  $ERRORS[ERR_UPLOAD_ICON_MV_FAILED] = '上传头像系统出现错误，请重试';
define('ERR_UPLOAD_ICON_DISK_ERROR', 1129); $ERRORS[ERR_UPLOAD_ICON_DISK_ERROR] = '上传头像系统出现错误，请重试';
define('ERR_USER_NICK_NAME_EXIST', 1130);   $ERRORS[ERR_USER_NICK_NAME_EXIST] = '昵称已存在，请您换一个尝试';
define('ERR_DEL_TOPIC_DENY', 1131);         $ERRORS[ERR_DEL_TOPIC_DENY] = '您无权限删除此话题';
define('ERR_ARTICLE_NOT_EXIST', 1132);      $ERRORS[ERR_ARTICLE_NOT_EXIST] = '没有此文章';
define('ERR_UPLOAD_EMR_PHOTO_FAILED', 1133);$ERRORS[ERR_UPLOAD_EMR_PHOTO_FAILED] = '上传病历图片失败';
define('ERR_ORDER_NOTI_EXIST', 1134);       $ERRORS[ERR_ORDER_NOTI_EXIST] = '没有查找此订单';
