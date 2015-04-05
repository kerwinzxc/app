<?php

class cc_selector
{
  private static $cc_list = array(
      'utruck' => array(
        'dbname'  => 'utruck',
        'host'    => '127.0.0.1',
        'port'    => 8379,
        ),
      'utruck_r' => array(
        'dbname'  => 'utruck',
        'host'    => '127.0.0.1:3306',
        'user'    => 'root',
        'passwd'  => 'shaovie',
        'charset' => 'utf8',
        ),
      );
  public static function get_cache($key)
  {
    if (isset(self::$db_list[$db]))
      return self::$db_list[$db];
    return array();
  }
};
