<?php

/*
*** EJigsaw Site Administration Suite
**
*** By Jigsaw Spain - www.jigsawspain.com
**
*** Initialisation and Function Library - File Build 0.3
*/


/*
** Classes
*/

class EJ_mysql
/*
Create simple mysql connection and query object
*/
{
	public $prefix;
	private $connect;
	private $result;
	
	function __construct($_host, $_user, $_pass, $_db, $_prefix)
	{
		$this->prefix = $_prefix;
		$this->connect = mysql_connect($_host, $_user, $_pass) or print("<p class=\"EJ_Error\"><strong>ERROR 0</strong>: MYSQL Connection Error! Please Check Settings</p>");
		mysql_select_db($_db, $this->connect) or print("<p class=\"EJ_Error\"><strong>ERROR 0</strong>: MYSQL Connection Error! Please Check Settings</p>");
	}
	
	function __destruct()
	{
		mysql_close($this->connect);
	}
	
	function query($_query)
	{
		$this->result = mysql_query($_query, $this->connect);
		if ($this->result) return true; else print("<p class=\"EJ_Error\"><strong>ERROR 1:</strong> MYSQL Query Error!<br/>Error Details: ".mysql_error($this->connect)."</p>"); return false;
	}
	
	function numRows()
	{
		return mysql_num_rows($this->result);
	}
	
	function getRow()
	{
		return mysql_fetch_assoc($this->result);
	}
	
	function error()
	{
		return mysql_error($this->connect);
	}
}


/*
** Functions
*/

function EJ_error($errno, $details = "", $file = "", $line = "")
/*
Reports an error message to screen and ceases running the script
*/
{
	global $EJ_settings;
	global $EJ_mysql;
	if ($details!="" and $file != "" and $line!= "") $details = "'$details' in file '$file' on line $line";
	switch ($errno)
	{
		// MYSQL Errors
		case 2:
			$EJ_err_message = "EJigsaw is not properly installed!";
			$details = "Setting table not found! Please run 'install.php'";
		break;
		// Login/Authorisation Errors
		case 10:
			$EJ_err_message = "Cannot retrieve user details!";
			$details = "Login Aborted! Please contact the site administrator or support.";
		break;
		case 11:
			$EJ_err_message = "Cannot retrieve user details!";
		break;
		case 12:
			$EJ_err_message = '<strong>Authorisation Error</strong>: Invalid Key! Please try the following:<ul class="EJ_user_error_list"><li>Refreshing the page</li><li>Logging out and logging in again</li></ul>';
			$details = "None";
			$err_type=1;
		break;
		case 13:
			$EJ_err_message = '<strong>Authorisation Error</strong>: Cannot add user of equal or greater type';
			$details = "User creation cancelled!";
			$err_type=1;
		break;
		case 14:
			$EJ_err_message = '<strong>Authorisation Error</strong>: Cannot delete "admin"';
			$details = "User deletion cancelled!";
			$err_type=1;
		break;
		case 15:
			$EJ_err_message = '<strong>Authorisation Error</strong>: Cannot delete user of equal or greater type';
			$details = "User deletion cancelled!";
			$err_type=1;
		break;
		// User Admin Errors
		case 20:
			$EJ_err_message = "Unable to add new user!";
			$err_type=1;
		break;
		case 21:
			$EJ_err_message = "Username or Email Address already in use!";
			$details = "None";
			$err_type=1;
		break;
		case 22:
			$EJ_err_message = "Error sending confirmation email!";
			$details = "User creation cancelled!";
			$err_type=1;
		break;
		case 23:
			$EJ_err_message = "Cannot delete user! User not found!";
			$details = "Please try agin.";
			$err_type=1;
		break;
		case 24:
			$EJ_err_message = "Unable to delete user!";
			$err_type=1;
		break;
		// Settings Admin Errors
		case 30:
			$EJ_err_message = "Error retrieving setting data";
			$err_type=1;
		break;
		case 31:
			$EJ_err_message = "Error changing setting";
			$err_type=1;
		break;
		// Module Admin Errors
		case 40:
			$EJ_err_message = "Module Not Found!";
			$details = "Module Name : ".$_REQUEST['module'];
			$err_type=1;
		break;
		case 41:
			$EJ_err_message = "Duplicate Module Class Found! Please consult the module creator";
			$details = "Module File : ".$details;
			$err_type=1;
		break;
		// Unknown Error
		default :
			$EJ_err_message = "Unknown error! Please contact support at <a href=\"mailto:admin@jigsawspain.com?subject=EJigsaw Unknown Error\">ejsupport@jigsawspain.com</a>";
		break;
	}
	if ($err_type!=1) {
		$err_message = "	<p class=\"EJ_Error\">
			<strong>ERROR $errno</strong>: $EJ_err_message<br/>
			Error Details: ";
	} else {
		$err_message = "	<p class=\"EJ_user_error\">
			<strong>ERROR $errno</strong>: $EJ_err_message<br/>
			Error Details: ";
	}
	$details!="" ? $err_message .= $details : $err_message .= $EJ_mysql->error() ;
	$err_message .= "
	</p>";
	print($err_message);
}

function EJ_showCpButtons()
/*
Display the buttons on the control panel
*/
{
	if ($_SESSION['usertype']>=5)
	{
		echo '<a href="uadmin.php" class="button" id="uadmin">User Admin</a><a href="settings.php" class="button" id="settings">Site Settings</a><a href="modules.php" class="button" id="modules">Modules</a>';
	}
	echo '<a href="profile.php" class="button" id="profile">Edit Profile</a><a href="login.php?action=Logout" class="button" id="logout">Log Out</a>';
}

function EJ_showFooter()
/*
Diplay the page footer
*/
{
	echo "<div id=\"foot\">
		<p>EJigsaw Site Administration Suite | pieced together by <a href=\"http://www.jigsawspain.com\" target=\"_blank\">Jigsaw Spain <img src=\"http://www.jigsawspain.com/images/small_brown_piece.png\" alt=\"Website Design by Jigsaw Spain\" class=\"middle\"/></a><br/>&copy 2011 Jigsaw Spain | <a href=\"http://www.jigsawspain.com\" target=\"_blank\">www.jigsawspain.com</a></p>
	</div>
";
}

function EJ_showMenu()
/*
Display the main menu
*/
{
	global $EJ_settings;
	global $EJ_modules;
	
	echo '
		<div class="menu">
			<div class="menu_button">Main Menu</div>
			<a href="'.$EJ_settings['instloc'].'" class="menu_item"><img src="'.$EJ_settings['instloc'].'images/cpanel_small.png" alt="" /> Main Control Panel</a>';
	if ($_SESSION['usertype']>=5)
	{
		echo '
			<a href="'.$EJ_settings['instloc'].'uadmin.php" class="menu_item"><img src="'.$EJ_settings['instloc'].'images/uadmin_small.png" alt="" /> User Administration</a>
			<a href="'.$EJ_settings['instloc'].'settings.php" class="menu_item"><img src="'.$EJ_settings['instloc'].'images/settings_small.png" alt="" /> Site Settings</a>
			<a href="'.$EJ_settings['instloc'].'modules.php" class="menu_item"><img src="'.$EJ_settings['instloc'].'images/modules_small.png" alt="" /> Modules</a>';
	}
	echo '
			<a href="'.$EJ_settings['instloc'].'profile.php" class="menu_item"><img src="'.$EJ_settings['instloc'].'images/profile_small.png" alt="" /> Edit Profile</a>
			<a href="'.$EJ_settings['instloc'].'login.php?action=Logout" class="menu_item"><img src="'.$EJ_settings['instloc'].'images/logout_small.png" alt="" /> Log Out</a>
		</div>
';
	if (count($EJ_modules)>0 and $_SESSION['usertype']>=5)
	{
		$modules_menu = '
		<div class="menu">
			<div class="menu_button">Module Menu</div>';
		$modules_data = "";
		foreach ($EJ_modules as $module)
		{
			if ($module['found'] == 1 and method_exists($module['moduleid'], 'admin_page')) {
				if (file_exists('modules/'.$module['moduleid'].'/icon.png'))
				{
					$modules_data .= '
				<a href="'.$EJ_settings['instloc'].'?module='.$module['moduleid'].'&action=admin_page" class="menu_item"><img src="'.$EJ_settings['instloc'].'modules/'.$module['moduleid'].'/icon.png" alt="" /> '.$module['name'].'</a>';
				} else 
				{
					$modules_data .= '
				<a href="'.$EJ_settings['instloc'].'?module='.$module['moduleid'].'&action=admin_page" class="menu_item">'.$module['name'].'</a>';
				}
			}
		}
		$modules_menu .= $modules_data . '
		</div>';
		if ($modules_data != "") echo $modules_menu;
	}
	echo '<div style="float:right; font-size: 1.2em; font-weight: bold; line-height: 20px; vertical-align: middle; margin-right: 10px; color: #42769B;">'.$EJ_settings['sitename'].'</div>';
}

/*
** Script Initialisation
*/
//error_reporting(E_ERROR);
set_error_handler("EJ_error", E_ERROR);
require('config.inc.php');
$EJ_mysql = new EJ_mysql($EJ_settings['mysqlhost'], $EJ_settings['mysqluser'], $EJ_settings['mysqlpass'], $EJ_settings['mysqldb'], $EJ_settings['mysqlprefix']);

// Fetch settings
$EJ_mysql->query("SHOW TABLES LIKE '{$EJ_mysql->prefix}settings'");
if ($EJ_mysql->numRows()==0) EJ_error(2);
$EJ_mysql->query("SELECT * FROM {$EJ_mysql->prefix}settings");
while ($EJ_settings['mysqlarray'] = $EJ_mysql->getRow())
{
	$EJ_settings[$EJ_settings['mysqlarray']['setting']] = $EJ_settings['mysqlarray']['value'];
}

// Version Checking
$curr_ver = 0.2;

if ($EJ_settings['version']<$curr_ver)
{
	$page_errors .= "<p class=\"EJ_user_message\">EJigsaw update detected! Please run <a href=\"install.php\">install.php</a><br/>Installed Version: ".$EJ_settings['version']."<br/>Current Version: ".$curr_ver."</p>";
}

/*
** Page Initialisation
*/

// Clear config.inc.php MYSQL settings for security
unset($EJ_settings['mysqlhost'], $EJ_settings['mysqluser'], $EJ_settings['mysqlpass'], $EJ_settings['mysqldb'], $EJ_settings['mysqlprefix']);

// Login check and redirection
session_start();
if ($EJ_initPage != 'widget' and $EJ_initPage != 'login' and $EJ_initPage != 'ajax')
{
	if (empty($_SESSION['userid']))
	{
		unset($EJ_settings['mysqlarray']);
		require($_SERVER['DOCUMENT_ROOT'].$EJ_settings['instloc'].'login.php');
		die();
	}
}

// Get Module Data
//if ($EJ_initpage != 'admin')
//{
	$EJ_mysql->query("SELECT moduleid, version, name, creator FROM {$EJ_mysql->prefix}modules ORDER BY name");
	if ($EJ_mysql->numRows()!=0)
	{
		while ($module = $EJ_mysql->getRow())
		{
			require_once('modules/ej_module_'.$module['moduleid'].'.php');
			$EJ_modules[$module['moduleid']] = $module;
			$EJ_modules[$module['moduleid']]['found'] = 1;
		}
	}
//}

// Special Action Check
if (isset($_REQUEST['action']))
{
	switch ($_REQUEST['action'])
	{
		case 'logout':
			if ($EJ_initPage != 'login')
			{
				unset($EJ_settings['mysqlarray']);
				require($_SERVER['DOCUMENT_ROOT'].$EJ_settings['instloc'].'login.php');
				die();
			}
		break;
	}
}

// Complete initialisation
unset($EJ_settings['mysqlarray']);
?>