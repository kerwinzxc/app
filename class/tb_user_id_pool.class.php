<?php

class tb_user_id_pool
{
  public static function get_new_user_id()
  {
    $db = new sql(db_selector::get_db(db_selector::$db_w));
    if ($db->execute('insert into user_id_pool()value()') === false) {
      return false;
    }
    return $db->get_insert_id();
  }
};
