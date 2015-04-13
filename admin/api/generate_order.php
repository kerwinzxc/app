<?php

require_once './def.inc.php';
require_once ROOT . 'api/util.class.php';
require_once ROOT . 'api/cache.class.php';
require_once ROOT . 'libs/driver_mb_db.inc.php';

$lbs_coords = array(array("116.328667","40.002981"), // 清华
array("116.376673","39.973571"),//  北太平庄
array("116.491081","39.908515"),//  北京东站
array("116.328955","39.900988"),//  北京西站
array("116.217421","40.009391"),//  北京植物园
array("116.292735","40.098418"),//  辛庄桥
array("116.622449","40.060657"),//  首都机场
array("114.660837","39.360837"),//  涞源县
array("117.081232","39.978437"),//  三河市
);
$lbs_coords = array(array("114.528319","38.05583"), // 石家庄
);
$lbs_coords = array(array("116.328955","39.900988"),//  北京西站
);

function do_insert_yun_dan($lng, $lat)
{
  $retry_count = 2;
  do {
    $order_id = util::generate_order_id();
    if (driver_mb_db::insert_yun_dan(
      $order_id,
      10002,
      $lng, $lat))
      break;
  }while ($retry_count-- > 0);
}

for ($i = 0; $i < 1; $i++)
{
  foreach ($lbs_coords as $coord)
    do_insert_yun_dan($coord[0], $coord[1]);
}
cache::set("newest_order_time", (string)time());

