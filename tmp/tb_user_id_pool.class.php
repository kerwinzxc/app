<?php

class tb_user_id_pool
{
  public static function get_new_user_id()
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    if ($db->execute('replace into user_id_pool(n)value(1)') === false) {
      return false;
    }
    return $db->get_insert_id();
  }
};
