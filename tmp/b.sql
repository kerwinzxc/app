
-- 病友吧-帖子自增ID
drop table if exists ba_post_id_pool;
create table if not exists ba_post_id_pool (
  id                  int unsigned not null auto_increment,   # 帖子ID
  n                   int not null default 0,

  primary key(id),
  unique key n(`n`)
}engine=MyISAM default charset=utf8;
