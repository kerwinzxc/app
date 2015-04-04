<?php

// table `user'
$tb_user = <<<'EOT'
drop table if exists user;
create table if not exists user (
  uid                 int unsigned not null primary key,      #
  phone_num           char(15) not null unique key,           # mobile phone number

  name                varchar(30) not null default 'null',    #
  sex                 tinyint not null,                       # 0: famale 1: male
  birth_year          smallint not null,                      # 

  c_time              int unsigned not null default 0,

  index idx_name(`name`)
)engine=InnoDB default charset=utf8;
EOT;

