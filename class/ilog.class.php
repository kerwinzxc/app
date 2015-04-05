<?php

class ilog
{
  private static $debug_fp = false;
  private static $rinfo_fp = false;
  private static $error_fp = false;
  private static $fatal_fp = false;

  private static $DEBUG = 1;
  private static $RINFO = 2;
  private static $ERROR = 3;
  private static $FATAL = 4;

  private static function log($type, $str)
  {
    $fp = false;
    if ($type === self::$DEBUG) {
      if (self::$debug_fp === false) {
        self::$debug_fp = @fopen(LOG_DIR . "/debug.log", "a+");
        $fp = self::$debug_fp;
      }
    } elseif ($type === self::$RINFO) {
      if (self::$rinfo_fp === false) {
        self::$rinfo_fp = @fopen(LOG_DIR . "/rinfo.log", "a+");
        $fp = self::$rinfo_fp;
      }
    } elseif ($type === self::$ERROR) {
      if (self::$error_fp === false) {
        self::$error_fp = @fopen(LOG_DIR . "/error.log", "a+");
        $fp = self::$error_fp;
      }
    } elseif ($type === self::$FATAL) {
      if (self::$fatal_fp === false) {
        self::$fatal_fp = @fopen(LOG_DIR . "/fatal.log", "a+");
        $fp = self::$fatal_fp;
      }
    }
    if ($fp !== false) {
      $log_str = date('Y-m-d H:i:s') . " > " . $str . "\n";
      @fwrite($fp, $log_str, strlen($log_str));
      @fflush($fp);
    }
  }

  public static function debug($str) 
  {
    self::log(self::$DEBUG, $str);
  }
  public static function rinfo($str) 
  {
    self::log(self::$RINFO, $str);
  }
  public static function error($str) 
  {
    self::log(self::$ERROR, $str);
  }
  public static function fatal($str) 
  {
    self::log(self::$FATAL, $str);
  }
}
