-- cuisw 04-12
alter table user add id_card char(18) not null default '' after name;

-- cuisw 04-08
-- alter table user add default_patient char(32) not null default '' after birth_year;
