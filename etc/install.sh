#初始化云服务
fdisk -S 56 /dev/xvdb 对数据盘进行分区；根据提示，依次输入“n”，“p”“1”，两次回车，“wq”，分区就开始了

mkfs.ext3 /dev/xvdb1
mkdir /data
echo '/dev/xvdb1  /data ext3    defaults    0  0' >> /etc/fstab
mount -a

echo never > /sys/kernel/mm/transparent_hugepage/enabled
echo "vm.overcommit_memory = 1" >> /etc/sysctl.conf
sysctl vm.overcommit_memory=1

#
rpm -ivh http://nginx.org/packages/centos/6/noarch/RPMS/nginx-release-centos-6-0.el6.ngx.noarch.rpm
yum -y install nginx


#
PHPUSER=ddky
PHPROOT=/home/$PHPUSER/local

yum install libxml2-devel
yum install bzip2-devel
yum install libcurl-devel
yum install libjpeg libpng freetype libjpeg-devel libpng libpng-devel freetype-devel

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
