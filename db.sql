-- tinyint     0~127
-- smallint    0~32767
-- int         0~2187483647
-- bigint
-- )engine=InnoDB default charset=utf8  or  engine=MyISAM
-- user id len = 63
-- nick name len = 30
-- md5 len = 32
-- mobile phone number = 15

-- 员工信息
drop table if exists employe;
create table employe (
  user                varchar(30) not null primary key,       #
  passwd              varchar(32) not null,                   #
  name                varchar(30) not null,                   #

  c_time              int not null default 0,                 # create time
  index i_name(`name`)
)engine=MyISAM default charset=utf8;

drop table if exists user;
create table if not exists user (
  id                  int unsigned not null auto_increment,   #
  phone_num           char(15) not null,                      # mobile phone number
  passwd              char(32) not null,                      # md5

  name                varchar(30) not null default '',        #
  id_card             char(18) not null default '',           # person id card
  icon_url            varchar(255) not null default '',       #
  default_patient     int unsigned not null default 0,        #

  c_time              int unsigned not null default 0,

  primary key(id),
  unique key phone(`phone_num`),
  index i_id_card(`id_card`)
)engine=MyISAM default charset=utf8 auto_increment=10000;

-- user's patient info 用户的常用就诊人
drop table if exists user_patient;
create table if not exists user_patient (
  id                  int unsigned not null auto_increment,   #
  user_id             int unsigned not null,                  # owner id
  phone_num           char(15) not null,                      # mobile phone number

  name                varchar(30) not null default '',        #
  id_card             char(18) not null default '',           # person id card
  sex                 tinyint not null default 1,             # 0: famale 1: male
  birthday            date not null default '1900-01-01',     # 

  primary key(id),
  index i_uid(`user_id`),
  unique key(`id_card`)
)engine=MyISAM default charset=utf8 auto_increment=10000;

-- 用户关注的医生
drop table if exists user_gz_doctor;
create table if not exists user_gz_doctor (
  user_id             int unsigned not null,                  # master id
  doctor_id           int unsigned not null,                  #

  primary key(`user_id`, `doctor_id`)
)engine=MyISAM default charset=utf8;

-- 用户关注的科室
drop table if exists user_gz_ke_shi;
create table if not exists user_gz_ke_shi (
  user_id             int unsigned not null,                  # master id
  ke_shi              int unsigned not null default 0,        #

  primary key(`user_id`, `ke_shi`)
)engine=MyISAM default charset=utf8;

-- 用户关注的病友吧
drop table if exists user_gz_ba;
create table if not exists user_gz_ba (
  user_id             int unsigned not null,                  # master id
  ba_id               int unsigned not null default 0,        #

  primary key(`user_id`, `ba_id`),
  index i_ba_id(`ba_id`)
)engine=MyISAM default charset=utf8;

-- 就诊人病历 electronic medical record
drop table if exists patient_emr;
create table if not exists patient_emr (
  id                  int unsigned not null auto_increment,   #
  user_id             int unsigned not null,                  #
  patient_id          int unsigned not null,                  #

  sd_time             int unsigned not null default 0,        # see doctor time
  hospital            varchar(90) not null default '',        # 就诊医院
  ke_shi              varchar(90) not null default '',        # 科室
  doctor_name         varchar(30) not null default '',        # 医生姓名
  photoes_1           varchar(350) not null default '',       # ,分隔的检查报告照片
  photoes_2           varchar(350) not null default '',       # ,分隔的处方报告照片

  doctor_diagnosis    varchar(450) not null default '',       # 医生诊断
  doctor_tell         varchar(450) not null default '',       # 医生嘱咐

  primary key(id),
  index i_pid(`patient_id`)
)engine=MyISAM default charset=utf8;

-- 用户消息
drop table if exists user_msg;
create table if not exists user_msg (
  id                  int unsigned not null auto_increment,   #
  user_id             int unsigned not null,                  #

  msg_type            int unsigned not null default 0,        # 消息类型
  readed              tinyint not null default 0,             # 已读/未读      1/0
  send_time           int unsigned not null default 0,        # 消息发送时间
  title               varchar(90) not null default '',        # 消息主题
  content             varchar(12000) not null default '',     # 消息内容

  primary key(id),
  index i_u(`user_id`),
  index i_mtype(`msg_type`)
)engine=MyISAM default charset=utf8;

-- doctor info
drop table if exists doctor;
create table if not exists doctor (
  id                  int unsigned not null auto_increment,   #
  phone_num           char(15) not null default '',           # mobile phone 
  passwd              char(32) not null default '',           # md5
  employe_id          varchar(30) not null default '',        # 录入者

  master_id           int unsigned not null default 0,        # 所长
  classify            tinyint not null default 0,             # 医生类别
  name                varchar(30) not null default '',        #
  sex                 tinyint not null default 1,             # 0: famale 1: male
  origin_icon_url     varchar(255) not null default '',       #
  icon_url            varchar(255) not null default '',       #

  ke_shi              int unsigned not null default 0,        # 科室
  tec_title           smallint not null default 0,            # 技术职称
  aca_title           smallint not null default 0,            # 学术职称
  adm_title           smallint not null default 0,            # 行政职称
  hospital            varchar(90) not null default '',        # 所属医院
  expert_in           varchar(450) not null default '',       # 擅长

  c_time              int unsigned not null default 0,

  primary key(id),
  unique key(phone_num),
  index i_name(`name`),
  index i_employe(`employe_id`),
  index i_cls(`classify`),
  index i_ke_shi(`ke_shi`)
)engine=MyISAM default charset=utf8 auto_increment=10000;

-- 病友吧
drop table if exists ba;
create table if not exists ba (
  id                  int unsigned not null,                  # 病种ID
  primary key(id)
)engine=MyISAM default charset=utf8;

-- 病友吧-帖子
drop table if exists ba_topic;
create table if not exists ba_topic (
  id                  int unsigned not null auto_increment,   # 帖子ID
  ba_id               int unsigned not null default 0,        # 病友吧ID

  user_id             int unsigned not null default 0,        # author

  topic               varchar(90) not null default '',        #

  useful              int unsigned not null default 0,        # 有用的
  useless             int unsigned not null default 0,        # 无用的

  c_time              int unsigned not null default 0,

  primary key(id),
  index i_ba_id(`ba_id`),
  index i_useful(`useful`)
)engine=MyISAM default charset=utf8;

-- 病友吧-帖子回复
drop table if exists ba_topic_reply;
create table if not exists ba_topic_reply (
  id                  int unsigned not null auto_increment,   # 回帖ID
  topic_id            int unsigned not null default 0,        # 所属帖子ID

  user_id             int unsigned not null,                  # 该回复的作者
  topic_author_id     int unsigned not null,                  # 帖主ID(冗余字段)

  content             varchar(12000) not null default '',     # 
  c_time              int unsigned not null default 0,

  primary key(id),
  index i_tid(`topic_id`)
)engine=MyISAM default charset=utf8;

-- 专家文章
drop table if exists doctor_article;
create table if not exists doctor_article (
  id                  int unsigned not null auto_increment,   # 文章ID
  doctor_id           int unsigned not null default 0,        # 医生ID

  topic               varchar(90) not null default '',        #
  content             varchar(12000) not null default '',     # 
  c_time              int unsigned not null default 0,

  primary key(id),
  index i_did(`doctor_id`)
)engine=MyISAM default charset=utf8;

-- 专家视频
drop table if exists doctor_video;
create table if not exists doctor_video (
  id                  int unsigned not null auto_increment,   # 视频ID
  doctor_id           int unsigned not null default 0,        # 医生ID

  topic               varchar(90) not null default '',        #
  video_url           varchar(255) not null default '',       #
  c_time              int unsigned not null default 0,

  primary key(id),
  index i_did(`doctor_id`)
)engine=MyISAM default charset=utf8;

