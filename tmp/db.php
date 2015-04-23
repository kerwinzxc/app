$sql = file_get_contents(dirname(__FILE__) . '/mysql.sql');
$ps  = explode('#--SPLIT--', $sql);

foreach ($ps as $p)
{
  $p = preg_replace('/^\s*#.*$/m', '', $p);

  mysql_query($p);
  if (mysql_errno())
  {
    die(' Error '.mysql_errno().': '.mysql_error());
  }
}

