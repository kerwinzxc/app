<?php
/*  
 * @author cuisw
 * @date 2015-03-03
 * @function logout from system
 */ 

session_start();
unset($_SESSION["user"]); 

header('Location: login.php');
exit;
