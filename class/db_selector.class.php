<?php

class db_selector
{
  public static $db_w = 'ddky_w';
  public static $db_r = 'ddky_r';

  private static $db_list = array(
      'ddky_w' => array(
        'dbname'  => 'ddky',
        'host'    => '127.0.0.1:3306',
        'user'    => 'root',
        'passwd'  => 'zhongwei',
        'charset' => 'utf8',
        ),
      'ddky_r' => array(
        'dbname'  => 'ddky',
        'host'    => '127.0.0.1:3306',
        'user'    => 'root',
        'passwd'  => 'zhongwei',
        'charset' => 'utf8',
        ),
      );
  public static function get_db($db)
  {
    if (isset(self::$db_list[$db]))
      return self::$db_list[$db];
    ilog::error("db_selector - not found db:" . $db);
    return array();
  }
};
