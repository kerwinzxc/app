-- tinyint     0~127
-- smallint    0~32767
-- int         0~2187483647
-- bigint
-- )engine=InnoDB default charset=utf8  or  engine=MyISAM
-- user id len = 63
-- nick name len = 30
-- md5 len = 32
-- mobile phone number = 15

-- user id generator
drop table if exists user_id_pool;
create table user_id_pool (
    id                int unsigned not null auto_increment primary key
)engine=MyISAM default charset=utf8 auto_increment=10000;

-- user info
drop table if exists user;
create table if not exists user (
  uid                 int unsigned not null primary key,      #
  phone_num           char(15) not null unique key,           # mobile phone number
  passwd              char(32) not null,                      # md5

  name                varchar(30) not null default '',        #
  sex                 tinyint not null default 1,             # 0: famale 1: male
  birth_year          smallint not null default '1900',       # 

  c_time              int unsigned not null default 0,

  index idx_name(`name`)
)engine=InnoDB default charset=utf8;

-- doctor id generator
drop table if exists doctor_id_pool;
create table doctor_id_pool (
    id                int unsigned not null auto_increment primary key
)engine=MyISAM default charset=utf8 auto_increment=10000;

-- doctor info
drop table if exists doctor;
create table if not exists doctor (
  uid                 int unsigned not null primary key,      #
  phone_num           char(15) not null unique key,           # mobile phone number
  passwd              char(32) not null,                      # md5

  name                varchar(30) not null default 'null',    #
  sex                 tinyint not null default 1,             # 0: famale 1: male

  c_time              int unsigned not null default 0,

  index idx_name(`name`)
)engine=InnoDB default charset=utf8;

