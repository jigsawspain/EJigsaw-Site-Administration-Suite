<?php
$EJ_initPage = 'login';
require_once('init.inc.php');

switch ($_REQUEST['action'])
// Check if an action has been called
{
	case 'Login':
		// Check login details
		$EJ_mysql->query("SELECT * FROM {$EJ_mysql->prefix}users WHERE userid='".mysql_real_escape_string($_POST['user_id'])."' AND pass='".md5($_POST['user_pass'])."'");
		if ($EJ_mysql->numRows()!=1)
		// Login details not found. Prepare error message
		{
			unset($_SESSION['userid']);
			unset($_SESSION['usertype']);
			unset($_SESSION['userarray']);
			unset($_SESSION['key']);
			$EJ_error = "<p class=\"EJ_user_error\">Username/Password not found!<br/>Please try again or contact the site administrator.</p>";
		} else
		// Login details found. Setup session and redirect to index page
		{
			$user = $EJ_mysql->getRow();
			$_SESSION['userid'] = $_POST['user_id'];
			$_SESSION['usertype'] = $user['type'];
			$_SESSION['userarray'] = $user;
			unset($_SESSION['userarray']['pass']);
			unset($_SESSION['userarray']['type']);
			$_SESSION['key'] = md5(substr(time(),-4).rand(1000,9999));
			unset($user);
			unset($EJ_settings['mysqlquery']);
			unset($EJ_settings['mysqlresult']);
			header("location: {$EJ_settings['instloc']}");
		}
	break;
	case 'Logout':
		// Clear the session
		unset($_SESSION['userid']);
		unset($_SESSION['usertype']);
		unset($_SESSION['userarray']);
		unset($_SESSION['key']);
		session_destroy();
		$EJ_error = "<p class=\"EJ_user_error\">You have been logged out.<br/>Please log in below if you wish to continue.</p>";
	break;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOGIN REQUIRED - EJigsaw Site Administration Suite</title>
<link rel="stylesheet" href="styles/ej_styles_main.php" type="text/css" />
<link rel="stylesheet" href="styles/ej_styles_login.php" type="text/css" />
</head>

<body>
<div id="frame">
	<div id="header">
	</div>
	<div id="content">
		<div id="login_error"><?=$EJ_error?></div>
		<form name="login_form" id="login_form" action="login.php" method="post">
			User Name:<br/>
			<input name="user_id" type="text" id="user_id" value="<?=$_POST['user_id']?>" maxlength="20" /><br/>
			Password:<br/>
			<input name="user_pass" type="password" id="user_pass" value="<?=$_POST['user_pass']?>" maxlength="20" /><br/>
			<input type="submit" name="action" id="action" class="login_button" value="Login" /><br/>
		</form>
	</div>
	<?php
		EJ_showFooter();
	?>
</div>
</body>
</html>