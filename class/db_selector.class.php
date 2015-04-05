<?php

class db_selector
{
  public static $db_w = 'utruck_w';
  public static $db_r = 'utruck_r';

  private static $db_list = array(
      'utruck_w' => array(
        'dbname'  => 'utruck',
        'host'    => '127.0.0.1:3306',
        'user'    => 'root',
        'passwd'  => 'shaovie',
        'charset' => 'utf8',
        ),
      'utruck_r' => array(
        'dbname'  => 'utruck',
        'host'    => '127.0.0.1:3306',
        'user'    => 'root',
        'passwd'  => 'shaovie',
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
