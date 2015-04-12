-- tinyint     0~127
-- smallint    0~32767
-- int         0~2187483647
-- bigint
-- )engine=InnoDB default charset=utf8  or  engine=MyISAM
-- user id len = 63
-- nick name len = 30
-- md5 len = 32
-- mobile phone number = 15

-- read more than insert/update, so use `MyISAM'
drop table if exists user;
create table if not exists user (
  id                  int unsigned not null auto_increment,   #
  phone_num           char(15) not null,                      # mobile phone number
  passwd              char(32) not null,                      # md5

  name                varchar(30) not null default '',        #
  id_card             char(18) not null default '',           # person id card
  default_patient     int unsigned not null default 0,        #

  c_time              int unsigned not null default 0,

  primary key(id),
  unique key(phone_num),
  index idx_id_card(`id_card`)
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
  index idx_uid(`user_id`),
  unique key(`id_card`)
)engine=InnoDB default charset=utf8 auto_increment=10000;

-- 用户关注的医生
drop table if exists user_guan_zhu;
create table if not exists user_guan_zhu (
  user_id             int unsigned not null,                  # master id
  doctor_id           int unsigned not null,                  #

  primary key(`user_id`, `doctor_id`)
)engine=InnoDB default charset=utf8;

-- doctor info
drop table if exists doctor;
create table if not exists doctor (
  id                  int unsigned not null auto_increment,   #
  phone_num           char(15) not null,                      # mobile phone number
  passwd              char(32) not null,                      # md5

  name                varchar(30) not null default '',        #
  sex                 tinyint not null default 1,             # 0: famale 1: male
  icon_url            varchar(255) not null default '',       #

  title               smallint not null default 0,            # 职称
  hospital            varchar(90) not null default '',        # 所属医院
  expert_in           varchar(300) not null default '',       # 擅长

  c_time              int unsigned not null default 0,

  primary key(id),
  unique key(phone_num),
  index idx_name(`name`)
)engine=MyISAM default charset=utf8 auto_increment=10000;

