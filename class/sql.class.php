<?php
/**
 * @author cuisw
 * @create 15 04/04
 */

function __autoload($class_name) {
  require_once 'table.php';
}

class sql
{
  private $db = false;
  private $connected = false;

  private $db_name = '';
  private $host    = '';
  private $user    = '';
  private $passwd  = '';
  private $charset = 'utf8';

  //=
  function __construct($dbname, $host, $user, $passwd, $charset = 'utf8')
  {
    $this->db_name  = $dbname;
    $this->host     = $host;
    $this->user     = $user;
    $this->passwd   = $passwd;
    $this->charset  = $charset;
  }
  private function connect()
  {
    $this->db = @mysql_pconnect($this->host, $this->user, $this->passwd);
    if ($this->db === false) {
      $this->db_err("connect db (" . $this->host . ") failed");
      return false;
    }
    if (@mysql_select_db($this->db_name, $this->db) === false) {
      $this->db_err("select db(" . $this->db_name . ") failed");
      $this->close();
      return false;
    }
    if (@mysql_set_charset($this->charset, $this->db) === false) {
      $this->db_err("set charset(" . $this->charset . ") failed");
      $this->close();
      return false;
    }
    $this->connected = true;
    return true;
  } 
  private function close()
  {
    @mysql_close($this->db);
  }
  private function db_err($err = '*')
  {
    $errno = @mysql_errno();
    $errmsg = @mysql_error();
    ilog::error("db - " . "$err" . " - errno:$errno errmsg:$errmsg");
  }
  public function execute($sql)
  {
    if (!$this->connected) {
      if (!$this->connect()) {
        return false;
      }
    }

    $res = @mysql_query($sql, $this->db);
    if ($res !== false) {
      return $res;
    }
    $this->db_err("execute($sql)");
    return false;
  }
  public function escape($str)
  {
    if (!$this->connected) {
      if (!$this->connect()) {
        return false;
      }
    }
    return mysql_real_escape_string($str, $this->db);
  }
  // get one row
  public function get_row($sql)
  {
    $result = $this->execute($sql);
    if ($result === false) {
      return false;
    }

    $rows = array();
    while ($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
      $rows[] = $row;
    }
    @mysql_free_result($result);
    return empty($rows) ? array() : $rows[0];
  }
  // get all rows
  public function get_rows($sql)
  {
    $result = $this->execute($sql);
    if ($result === false) {
      return false;
    }

    $rows = array();
    while ($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
      $rows[] = $row;
    }
    @mysql_free_result($result);
    return $rows;
  }
  /**********************************************************************
   * Creates a SET nvp sql string from an associative array (and escapes all values)
   *
   *  Usage:
   *
   *     $db_data = array('login'=>'jv','email'=>'jv@vip.ie','user_id'=>1,'created'=>'NOW()');
   *     $db->execute("INSERT INTO users SET " . $db->get_set($db_data));
   *
   *     ...OR...
   *
   *     $db->execute("UPDATE users SET " . $db->get_set($db_data) . " WHERE user_id=1");
   *
   * Output:
   *
   *     login='jv',email='jv@vip.ie',user_id=1,created=NOW()
   */
  function get_set($params)
  {
    if (!is_array($params)) {
      $this->db_err('get_set params invalid');
      return false;
    }
    $sql = array();
    foreach ($params as $field => $val) {
      if ($val === 'true' || $val === true) {
        $val = 1;
      } else if ($val === 'false' || $val === false) {
        $val = 0;
      }
      if ($val === 'NOW()' || $val === 'NULL') {
        $sql[] = "$field=$val";
      } else {
        $sql[] = "$field='". $this->escape($val) . "'";
      }
    }
    return implode(',', $sql);
  }

  public function affected_rows()
  {
    return @mysql_affected_rows($this->db);
  }
  // get last insert id
  public function get_insert_id()
  {
    return @mysql_insert_id($this->db);
  }
};
