<?php
$EJ_initPage = 'widget';
require_once(dirname(__FILE__).'/init.inc.php');
session_start();
if (!isset($_SESSION['key']))
{
	$_SESSION['key'] = md5(substr(time(),-4).rand(1000,9999));
}

function EJ_bridgeModuleHead($moduleid)
{
	global $EJ_settings;
	if (empty($_REQUEST['module']))
	{
		$id = $moduleid;
	} else
	{
		$id = $_REQUEST['module'];
	}
	if (file_exists(dirname(__FILE__)."/modules/$id/styles.css"))
	{
		echo "<link rel=\"stylesheet\" href=\"{$EJ_settings['instloc']}modules/$id/styles.css\" type=\"text/css\" />";
	}
	if (file_exists(dirname(__FILE__)."/modules/$id/styles.php"))
	{
		echo "<link rel=\"stylesheet\" href=\"{$EJ_settings['instloc']}modules/$id/styles.php\" type=\"text/css\" />";
	}
	if (file_exists(dirname(__FILE__)."/modules/$id/$id.js"))
	{
		echo '<script src="'.$EJ_settings['instloc'].'modules/'.$id.'/'.$id.'.js" language="javascript" type="text/javascript"></script>';
	}
}

function EJ_bridgeModule($moduleid, $actionid)
{
	global $EJ_settings, $EJ_mysql;
	if (empty($_REQUEST['module']))
	{
		$id = $moduleid;
	} else
	{
		$id = $_REQUEST['module'];
	}
	require_once(dirname(__FILE__).'/modules/ej_module_'.$id.'.php');
	$_vars = $_REQUEST;
	unset($_vars['PHPSESSID']);
	$module = new $id($EJ_mysql, $_vars, $EJ_settings);
	if (isset($_REQUEST['action']) or !empty($actionid))
	{
		if (empty($_REQUEST['action']))
		{
			$action = $actionid;
		} else
		{
			$action = $_REQUEST['action'];
		}
		switch (strtolower($action))
		{
			case 'install' :
				echo "<p class=\"EJ_user_error\">Please use the EJigsaw Control Panel to Install modules</p>";
			break;
			case 'uninstall' :
				echo "<p class=\"EJ_user_error\">Please use the EJigsaw Control Panel to Uninstall modules</p>";
			break;
			case 'update' :
				echo "<p class=\"EJ_user_error\">Please use the EJigsaw Control Panel to Update modules</p>";
			break;
			default:
				if (method_exists($module, $action))
				{
					$module->$action();
				} else
				{
					echo "<p class=\"EJ_user_error\"><strong>MODULE ERROR</strong>: Action '".$action."' Not Found!</p>";
				}
			break;
		}
	} else
	{
		echo "<p class=\"EJ_user_error\"><strong>EJIGSAW MODULE ERROR:</strong> No Action requested!</p>";
	}
}
?>