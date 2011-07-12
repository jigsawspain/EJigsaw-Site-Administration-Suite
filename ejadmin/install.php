<?php

/*
*** EJigsaw Site Administration Suite
**
*** By Jigsaw Spain - www.jigsawspain.com
**
*** Installation Procedure - File Build 0.2
*/


/*
** Functions
*/

function EJ_error($errno)
/*
Reports an error message to screen and ceases running the script
*/
{
	global $EJ_settings;
	$details = "";
	switch ($errno)
	{
		case 0:
			$EJ_err_message = "Unable to connect to database! Please check configuration settings!";
			$details = "None";
		break;
		case 1:
			$EJ_err_message = "Unable to create table!";
		break;
		case 2:
			$EJ_err_message = "Error retrieving version data!";
		break;
		case 3:
			$EJ_err_message = "Error creating version data!";
		break;
		case 4:
			$EJ_err_message = "You are already using a newer version of EJigsaw! Cannot Update!";
			$details = "Current Version = {$EJ_settings['oldver']}";
		break;
		case 5:
			$EJ_err_message = "Error updating version data!";
		break;
		case 6:
			$EJ_err_message = "Error retrieving table data!";
		break;
		case 7:
			$EJ_err_message = "Error creating table data!";
		break;
		default :
			$EJ_err_message = "Unknown error! Please contact support at <a href=\"mailto:admin@jigsawspain.com?subject=EJigsaw Unknown Error\">ejsupport@jigsawspain.com</a>";
		break;
	}
	$err_message = "	<p class=\"EJ_instError\">
		<strong>ERROR $errno</strong>: $EJ_err_message<br/>
		Error Details: ";
	$details!="" ? $err_message .= $details : $err_message .= mysql_error($EJ_settings['mysqlconnect']) ;
	$err_message .= "
	</p>";
	die($err_message);
}


/*
** Initial Configuration and Initialisation
*/

error_reporting(E_ERROR);
require("config.inc.php");

$EJ_settings['ver'] = "0.2";

echo "<!DOCTYPE html>
<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>EJigsaw v{$EJ_settings['ver']} - Installation</title>
<link href=\"styles/ej_styles_inst.css\" rel=\"stylesheet\" type=\"text/css\">
</head>
<body>
<div id=\"frame\">
	<div id=\"header\">
	</div>
	<p class=\"EJ_instText\">
		*****<br/>
		** EJigsaw v{$EJ_settings['ver']}<br/>
		*****<br/>
		** Installation / Update Procedure<br/>
		*****
	</p>
	<p class=\"EJ_instText\">
		&gt;<br/>
		&gt;&gt; Starting Installation / Update...<br/>
		&gt;
	</p>";

$EJ_settings['mysqlconnect'] = mysql_connect($EJ_settings['mysqlhost'], $EJ_settings['mysqluser'], $EJ_settings['mysqlpass']);
if (!$EJ_settings['mysqlconnect']) EJ_error(0);
if (!mysql_select_db($EJ_settings['mysqldb'], $EJ_settings['mysqlconnect'])) EJ_error(0);


/*
** Initial Table Creation (If not already created)
*/

echo "
	<p class=\"EJ_instText\">
		&gt; Checking Tables...";

//Create Settings Table
$EJ_settings['mysqlquery'] = "CREATE TABLE IF NOT EXISTS {$EJ_settings['mysqlprefix']}settings (
	setting VARCHAR(20) NOT NULL ,
	name VARCHAR(20) NOT NULL ,
	value VARCHAR(150) NOT NULL ,
	`desc` TEXT ,
	editable tinyint(1) NOT NULL DEFAULT 1 ,
	PRIMARY KEY (setting)
)";
$EJ_settings['mysqlresult'] = mysql_query($EJ_settings['mysqlquery'], $EJ_settings['mysqlconnect']); 
if (!$EJ_settings['mysqlresult']) EJ_error(1);
echo "<br/>
		Settings table OK";

//Create Users Table
$EJ_settings['mysqlquery'] = "CREATE TABLE IF NOT EXISTS {$EJ_settings['mysqlprefix']}users (
	userid VARCHAR(20) NOT NULL ,
	pass VARCHAR(32) NOT NULL ,
	email VARCHAR(150) NOT NULL ,
	type TINYINT(1) NOT NULL  DEFAULT 0 ,
	PRIMARY KEY (userid)
)";
$EJ_settings['mysqlresult'] = mysql_query($EJ_settings['mysqlquery'], $EJ_settings['mysqlconnect']); 
if (!$EJ_settings['mysqlresult']) EJ_error(1);
echo "<br/>
		Users table OK";

//Create Modules Table
$EJ_settings['mysqlquery'] = "CREATE TABLE IF NOT EXISTS {$EJ_settings['mysqlprefix']}modules (
	moduleid VARCHAR(20) NOT NULL,
	version VARCHAR(20) NOT NULL ,
	name VARCHAR(100) NOT NULL ,
	creator VARCHAR(50) NOT NULL ,
	PRIMARY KEY (moduleid)
)";
$EJ_settings['mysqlresult'] = mysql_query($EJ_settings['mysqlquery'], $EJ_settings['mysqlconnect']); 
if (!$EJ_settings['mysqlresult']) EJ_error(1);
echo "<br/>
		Modules table OK";

echo "<br/>
		&gt; Done
	</p>";


/*
** Main Version Control
*/

echo "
	<p class=\"EJ_instText\">
		&gt; Checking Version Data...";

// Retrieve Existing Version
$EJ_settings['mysqlquery'] = "SELECT value FROM {$EJ_settings['mysqlprefix']}settings WHERE setting = 'version'";
$EJ_settings['mysqlresult'] = mysql_query($EJ_settings['mysqlquery'], $EJ_settings['mysqlconnect']); 
if (!$EJ_settings['mysqlresult']) EJ_error(2);

if (mysql_num_rows($EJ_settings['mysqlresult'])==0)
// Version doesn't exist (clean installation)
{
	$EJ_settings['mysqlquery'] = "INSERT INTO {$EJ_settings['mysqlprefix']}settings (setting, name, value, editable) VALUES 
	('version', 'Version', '{$EJ_settings['ver']}', 0)";
	$EJ_settings['mysqlresult'] = mysql_query($EJ_settings['mysqlquery'], $EJ_settings['mysqlconnect']);
	if (!$EJ_settings['mysqlresult']) EJ_error(3);
	echo "<br/>
		Version data added";
} else 
// Version found, check and update
{
	$EJ_settings['mysqlarray'] = mysql_fetch_assoc($EJ_settings['mysqlresult']);
	$EJ_settings['oldver'] = $EJ_settings['mysqlarray']['value'];
	if (number_format($EJ_settings['oldver']>$EJ_settings['ver']))
	// Newer version already installed
	{
		EJ_error(4);
	} elseif ($EJ_settings['oldver']!=$EJ_settings['version'])
	// Update version data
	{
		switch ($EJ_settings['oldver'])
		{
			default :
			break;
		}
		$EJ_settings['mysqlquery'] = "UPDATE {$EJ_settings['mysqlprefix']}settings SET 
		value = '{$EJ_settings['ver']}' WHERE setting = 'version'";
		$EJ_settings['mysqlresult'] = mysql_query($EJ_settings['mysqlquery'], $EJ_settings['mysqlconnect']);
		if (!$EJ_settings['mysqlresult']) EJ_error(5);
		echo "<br/>
		Version data updated";
	}
}

echo "<br/>
		&gt; Done
	</p>";


/*
** Create Initial Table Data (If not already created)
*/

$EJ_settings['mysqlquery'] = "SELECT userid FROM {$EJ_settings['mysqlprefix']}users WHERE userid = 'admin'";
$EJ_settings['mysqlresult'] = mysql_query($EJ_settings['mysqlquery'], $EJ_settings['mysqlconnect']); 
if (!$EJ_settings['mysqlresult']) EJ_error(6);

$EJ_settings['mysqlquery2'] = "SELECT value FROM {$EJ_settings['mysqlprefix']}settings WHERE setting = 'sitename' or setting = 'siteemail'";
$EJ_settings['mysqlresult2'] = mysql_query($EJ_settings['mysqlquery2'], $EJ_settings['mysqlconnect']); 
if (!$EJ_settings['mysqlresult2']) EJ_error(6);


if (mysql_num_rows($EJ_settings['mysqlresult'])==0 or mysql_num_rows($EJ_settings['mysqlresult2'])!=3)
// Some settings not set
{
echo "
	<p class=\"EJ_instText\">
		&gt; Populating Tables...";

// Set initial User data
$EJ_settings['mysqlquery'] = "INSERT INTO {$EJ_settings['mysqlprefix']}users (userid, pass, email, type) VALUES
	('admin', MD5('abc123'), 'admin@yourdomain.com', 9)
	ON DUPLICATE KEY UPDATE userid = userid";
$EJ_settings['mysqlresult3'] = mysql_query($EJ_settings['mysqlquery'], $EJ_settings['mysqlconnect']); 
if (!$EJ_settings['mysqlresult3']) EJ_error(7);
if (mysql_num_rows($EJ_settings['mysqlresult'])==0)
echo "<br/>
		Populated users table";

// Set initial Settings data
$EJ_settings['mysqlquery'] = "INSERT INTO {$EJ_settings['mysqlprefix']}settings (setting, name, value, `desc`) VALUES
	('siteemail', 'Site Email', 'setthis@yourdomain.com', 'A contact email address for your site. Automatically generated emails to users will be shown as having been sent from this address.') ,
	('sitename', 'Site Name', 'EJigsaw Site', 'A short name for your website. This will appear in automatically generated emails to users (e.g. Kind Regards, {Site Name})') ,
	('siteaddress', 'Site Address', 'www.yourdomain.com', 'The home page address of your site. This should be as you want it to appear on emails and corespondence sent from the site. (Note: do NOT include the \'http://\')')
	ON DUPLICATE KEY UPDATE setting = setting";
$EJ_settings['mysqlresult3'] = mysql_query($EJ_settings['mysqlquery'], $EJ_settings['mysqlconnect']); 
if (!$EJ_settings['mysqlresult3']) EJ_error(7);
if (mysql_num_rows($EJ_settings['mysqlresult2'])!=3)
echo "<br/>
		Populated settings table";


echo "<br/>
		&gt; Done
	</p>";
}


/*
** Installation Completion
*/

mysql_close($EJ_settings['mysqlconnect']);
echo "
	<p class=\"EJ_instText\">
		&gt;<br/>
		&gt;&gt; Installation / Update Completed Successfully!<br/>
		&gt;<br/>
		&gt; Your are now using version {$EJ_settings['ver']}<br/>
		&gt; It is recommended that you now delete the 'install.php' file from your server, or rename it to prevent unauthorised access.<br/>
		&gt;
	</p>
	<p class=\"EJ_instText\">
		To access the control panel, please follow the link below and login.<br/>(default username: admin, password: abc123)<br/>
		<a href=\"{$EJ_settings['instloc']}\">Control Panel</a>
	</p>
</div>
</body>
</html>";

?>