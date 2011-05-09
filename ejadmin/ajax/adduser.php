<?php

/*
*** EJigsaw Site Administration Suite
**
*** By Jigsaw Spain - www.jigsawspain.com
**
*** Add User AJAX Procedure - File Build 0.1
*/


$EJ_initPage ='ajax';
require('../init.inc.php');

// Check if user is correctly logged in (cross domain posting prevention)
if (!isset($_SESSION['userid']) or $_POST['key'] != $_SESSION['key'] or empty($_POST['key'])) EJ_error(12);

if ($_POST['type']>=$_SESSION['usertype'] and $_SESSION['usertype']!=9) EJ_error(13);

// Check if user already exists
$EJ_mysql->query("SELECT userid, email FROM {$EJ_mysql->prefix}users WHERE userid = '{$_POST['uname']}' OR email = '{$_POST['email']}'");
if ($EJ_mysql->numRows()!=0) EJ_error(21);

// Add new user
$i = 0;
$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
$pass = "";
while ($i<12)
{
	$pick = rand(0,strlen($chars)-1);
	$pass .= substr($chars,$pick,1);
	$i++;
}
$EJ_mysql->query("INSERT INTO {$EJ_mysql->prefix}users SET userid = '{$_POST['uname']}', email = '{$_POST['email']}', type = {$_POST['type']}, pass = MD5('$pass')");

// Send confirmation to new users email address
$to = $_POST['email'];
$from = $EJ_settings['sitename'].' <'.$EJ_settings['siteemail'].'>';
$subject = "User Account Created";
$message = "<html><p>This email is to confirm that the administrators at {$EJ_settings['sitename']} have created an account for you. The details of the account can be found below:</p><p><strong>Username</strong>: {$_POST['uname']}<br/><strong>Password</strong>: $pass</p><p>Although this password has been automatically generated, we strongly recommend you head over to <a href=\"http://{$EJ_settings['siteaddress']}\">http://{$EJ_settings['siteaddress']}</a> to log in and change it immediately.</p><p>If you think you have received this email in error, please hit reply, put 'CANCEL ACCOUNT' in the subject field, and hit send. This will mark the account for cancellation at the earliest opportunity.</p><p>If you should have any further queries, please do not hesitate to contact the Admin Team by replying to this message.</p><p>Kind Regards</p><p>Admin Team<br/><strong>{$EJ_settings['sitename']}</strong></p></html>";
$headers = "From: $from" . "\r\n" .
	"Reply-To: $from" . "\r\n" .
	"Content-Type: text/html; charset=\"iso-8859-1\"" . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

if (!mail($to, $subject, $message, $headers))
// Email sending failed, delete user
{
	$EJ_mysql->query("DELETE FROM {$EJ_mysql->prefix}users WHERE userid = '{$_POST['uname']}'");
	echo $to."::".$subject."::".$message."::".$headers;
	EJ_error(22);
}

// If everything has gone smoothly
echo '<p class="EJ_user_success">User Added Successfully</p>';
?>