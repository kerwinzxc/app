<?php

function class_loader($cls)
{
  $file = ROOT . '/../class/' . $cls . '.class.php';
  require_once($file);
}
spl_autoload_register('class_loader');

