<?php

require_once __DIR__ . '/../conf/settings.php';

class ilog 
{
  private static $fp = false;

  private static function log($level, $str)
  {
    if (self::$fp === false) {
      self::$fp = @fopen(LOG_DIR . LOG_FILE, "a+");
    }
    if (self::$fp) {
      $log_str = '[' . date('Y-m-d H:i:s') . "]:[" . $level . "]: " . $str . "\n";
      @fwrite(self::$fp, $log_str, strlen($log_str));
      @fflush(self::$fp);
    }
  }

  public static function debug($str) 
  {
    self::log("debug", $str);
  }
  public static function error($str) 
  {
    self::log("error", $str);
  }
  public static function rinfo($str) 
  {
    self::log("rinfo", $str);
  }
  public static function fatal($str) 
  {
    self::log("fatal", $str);
  }
}
