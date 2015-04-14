-- cuisw 04-14
alter table doctor add ke_shi smallint not null default 0 after icon_url;
alter table doctor add index idx_classify(`classify`);
alter table doctor add index idx_ke_shi(`ke_shi`);

-- cuisw 04-13
-- alter table doctor add classify tinyint not null default 0 after passwd;
-- alter table doctor add icon_url varchar(255) not null default '' after id_card;
-- alter table doctor drop title;
-- alter table doctor add tec_title smallint not null default 0 after icon_url;
-- alter table doctor add aca_title smallint not null default 0 after tec_title;
-- alter table doctor add hospital varchar(90) not null default '' after aca_title;
-- alter table doctor add expert_in varchar(300) not null default '' after hospital;

-- cuisw 04-12
-- alter table user add id_card char(18) not null default '' after name;
-- alter table doctor add icon_url varchar(255) not null default '' after name;
-- alter table doctor add title smallint not null default 0 after icon_url;
-- alter table doctor add hospital varchar(90) not null default '' after title;
-- alter table doctor add expert_in varchar(300) not null default '' after hospital;

-- cuisw 04-08
-- alter table user add default_patient char(32) not null default '' after birth_year;
