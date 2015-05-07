(echo -en "flushall\r\n"; sleep 1) | nc 192.168.0.220 6379
(echo -en "flushall\r\n"; sleep 1) | nc 192.168.0.220 6380
(echo -en "flushall\r\n"; sleep 1) | nc 192.168.0.220 6381
mysql -uroot -pzhongwei --default-character-set=utf8 ddky < db.sql
