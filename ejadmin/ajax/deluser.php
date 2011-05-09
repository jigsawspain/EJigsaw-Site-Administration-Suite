<?php

/*
*** EJigsaw Site Administration Suite
**
*** By Jigsaw Spain - www.jigsawspain.com
**
*** Add User AJAX Procedure - File Build 0.2
*/


$EJ_initPage ='ajax';
require('../init.inc.php');

// Check if user is correctly logged in (cross domain posting prevention)
if (!isset($_SESSION['userid']) or $_POST['key'] != $_SESSION['key'] or empty($_POST['key'])) EJ_error(12);

// Check if user exists, if so get user type
$EJ_mysql->query("SELECT type FROM {$EJ_mysql->prefix}users WHERE userid = '{$_POST['uname']}'");
if ($EJ_mysql->numRows()==0) EJ_error(23);
$user = $EJ_mysql->getRow();

// Check Authority to delete user
if ($_SESSION['usertype'] <= $user['type'] and $_SESSION['usertype']!=9) EJ_error(15);
if ($_POST['uname']=='admin') EJ_error(14);

// Delete the user
$EJ_mysql->query("DELETE FROM {$EJ_mysql->prefix}users WHERE userid = '{$_POST['uname']}'");

// If everything has gone smoothly
echo '<p class="EJ_user_success">User Deleted</p>';
?>