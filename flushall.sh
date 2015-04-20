(echo -en "flushall\r\n"; sleep 1) | nc 127.0.0.1 6379
mysql -uroot -pzhongwei --default-character-set=utf8 ddky < db.sql
