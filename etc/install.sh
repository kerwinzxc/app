PHPUSER=sparkcui
PHPROOT=/home/sparkcui/local

# php 5.6.8
./configure --prefix=$PHPROOT --disable-debug --with-layout=GNU --with-openssl --with-zlib --with-bz2 --with-libxml-dir --enable-ftp --with-gd --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib-dir --enable-mbstring --with-mysql --disable-ipv6 --enable-gd-native-ttf  --with-curl --enable-bcmath --enable-exif --with-gettext --with-mhash --enable-opcache --enable-pcntl --enable-fpm --with-fpm-user=$PHPUSER --with-fpm-group=$PHPUSER

# php redis
cd phpredis/
$PHPROOT/bin/phpize
./configure --with-php-config=$PHPROOT/bin/php-config
make clean
make && make install


# run
# test
$PHPROOT/sbin/php-fpm -c $PHPROOT/etc/php.ini -y $PHPROOT/etc/php-fpm.conf -t

$PHPROOT/sbin/php-fpm -c $PHPROOT/etc/php.ini -y $PHPROOT/etc/php-fpm.conf

#kill -INT `cat $PHPROOT/var/run/php-fpm.pid`
#kill -USR2 `cat $PHPROOT/var/run/php-fpm.pid`
