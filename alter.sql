-- cuisw 04-12
alter table user add id_card char(18) not null default '' after name;
alter table doctor add icon_url varchar(255) not null default '' after name;
alter table doctor add title smallint not null default 0 after icon_url;
alter table doctor add hospital varchar(90) not null default '' after title;
alter table doctor add expert_in varchar(300) not null default '' after hospital;

-- cuisw 04-08
-- alter table user add default_patient char(32) not null default '' after birth_year;
