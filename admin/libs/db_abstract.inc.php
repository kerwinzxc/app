<?php

abstract class db_abstract
{
  private $db = false;
  private $connected = false;

  private $db_name = '';
  private $host    = '';
  private $user    = '';
  private $passwd  = '';

  //=
  function __construct($dbname, $host, $user, $passwd)
  {
    $this->db_name  = $dbname;
    $this->host     = $host;
    $this->user     = $user;
    $this->passwd   = $passwd;
  }
  private function connect()
  {
    $this->db = @mysql_pconnect($this->host, $this->user, $this->passwd);
    if ($this->db === false)
    {
      $this->db_err("connect failed");
      return false;
    }
    if (@mysql_select_db($this->db_name, $this->db) === false)
    {
      $this->db_err("select db failed");
      return false;
    }
    mysql_set_charset('utf8', $this->db);
    $this->connected = true;
    return true;
  } 
  private function db_err($err = '')
  {
    if (defined('ECHO_DB_ERR'))
    {
      $errno = mysql_errno();
      $errmsg = mysql_error();
      echo "Error: db" . "($err)" . " errno=$errno<br> errmsg=$errmsg<br>";
    }
  }
  public function query($sql)
  {
    if (!$this->connected)
    {
      if (!$this->connect())
        return false;
    }

    $res = mysql_query($sql, $this->db);
    if ($res) return $res;
    $this->db_err("query");
    return false;
  }
};
