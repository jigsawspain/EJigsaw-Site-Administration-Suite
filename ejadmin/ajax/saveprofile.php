<?php

/*
*** EJigsaw Site Administration Suite
**
*** By Jigsaw Spain - www.jigsawspain.com
**
*** Save Profile AJAX Procedure - File Build 0.1
*/


$EJ_initPage ='ajax';
require('../init.inc.php');

// Check if user is correctly logged in (cross domain posting prevention)
if (!isset($_SESSION['userid']) or $_POST['key'] != $_SESSION['key'] or empty($_POST['key'])) EJ_error(12);

// Add new user
$i = 0;
$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
$EJ_mysql->query("UPDATE {$EJ_mysql->prefix}users SET email = '{$_POST['email']}', pass = MD5('{$_POST['pass']}') WHERE userid = '{$_SESSION['userid']}'");

// If everything has gone smoothly
echo '<p class="EJ_user_success">Profile Updated</p>';
?>