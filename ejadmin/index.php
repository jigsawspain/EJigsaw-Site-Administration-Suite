<?php
$EJ_initpage='admin';
require_once('init.inc.php');

if (!isset($_REQUEST['module'])) 
{
	$modules_content = "";
	$modules_data = "";
	if (count($EJ_modules)!=0 and $_SESSION['usertype']>=5)
	{
		$modules_content .= '
	<h1><img src="images/modules_small.png" align="Control Options" /> Module Admin Pages</h1>
	<div id="module_container">
	';
		foreach ($EJ_modules as $module)
		{
			require_once('modules/ej_module_'.$module['moduleid'].'.php');
			$mod = new $module['moduleid']($EJ_mysql, $_REQUEST, $EJ_settings);
			empty($mod->name) ? $name = $module['moduleid'] : $name = $mod->name;
			if (method_exists($mod, 'admin_page') and file_exists('modules/'.$module['moduleid'].'/icona.png'))
			{
				$modules_data .= "<a class=\"button\" style=\"background-image: url(modules/".$module['moduleid']."/icona.png)\" href=\"./?module={$module['moduleid']}&action=admin_page\">$name</a>";
			} elseif (method_exists($mod, 'admin_page'))
			{
				$modules_data .= "<a class=\"button\" style=\"background-image: url(images/icona.png)\" href=\"./?module={$module['moduleid']}&action=admin_page\">$name</a>";
			}
		}
		$modules_content .= $modules_data . '
	</div>';
		if ($modules_data == "") $modules_content = "";
	}
	
	?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EJigsaw Site Administration Suite</title>
<link rel="stylesheet" href="styles/ej_styles_main.php" type="text/css" />
<link rel="stylesheet" href="styles/ej_styles_index.php" type="text/css" />
</head>

<body>
<div id="frame">
	<div id="header">
		<div id="menu">
			<?php EJ_showMenu(); ?>
		</div>
	</div>
	<div id="content">
		<div id="warnings"><?=isset($warnings)?$warnings:"";?></div>
		<h1><img src="images/cpanel_small.png" alt="Control Options" /> Control Options</h1>
		<div id="container">
			<?php EJ_showCpButtons(); ?>
		</div>
		<?=$modules_content;?>		
	</div>
	<div id="page_errors"><?=$page_errors?></div>
	<?php EJ_showFooter(); ?>
</div>
</body>
</html>
<?php
} else
{
	$id = $_REQUEST['module'];
	require_once('modules/ej_module_'.$id.'.php');
	$_vars = $_REQUEST;
	unset($_vars['PHPSESSID']);
	$module = new $id($EJ_mysql, $_vars, $EJ_settings);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EJigsaw Site Administration Suite</title>
<link rel="stylesheet" href="styles/ej_styles_main.php" type="text/css" />
<?php
if (file_exists("modules/{$id}/styles.css"))
{
	echo "<link rel=\"stylesheet\" href=\"modules/{$id}/styles.css\" type=\"text/css\" />";
}
if (file_exists("modules/{$id}/styles.php"))
{
	echo "<link rel=\"stylesheet\" href=\"modules/{$id}/styles.php\" type=\"text/css\" />";
}
?>
</head>

<body>
<div id="frame">
	<div id="header">
		<div id="menu">
			<?php EJ_showMenu(); ?>
		</div>
	</div>
	<div id="content">
		<?php
		empty($module->name) ? $name = $id : $name = $module->name;
		if (file_exists("modules/{$id}/icon.png"))
		{
			echo "<h1><img src=\"modules/{$id}/icon.png\" alt=\"{$name}\" /> $name</h1>
";
		} else
		{
			echo "<h1>$name</h1>
";
		}
		?>
		<div id="container">
			<?php 
			if (isset($_REQUEST['action']))
			{
				switch (strtolower($_REQUEST['action']))
				{
					case 'install' :
						echo "<p class=\"EJ_user_error\">Please use <a href=\"modules.php\">Modules Page</a> to Install modules</p>";
					break;
					case 'uninstall' :
						echo "<p class=\"EJ_user_error\">Please use <a href=\"modules.php\">Modules Page</a> to Uninstall modules</p>";
					break;
					case 'update' :
						echo "<p class=\"EJ_user_error\">Please use <a href=\"modules.php\">Modules Page</a> to Update modules</p>";
					break;
					default:
						if (method_exists($module, $_REQUEST['action']) and $_SESSION['usertype']>=5)
						{
							$module->$_REQUEST['action']();
						} else
						{
							echo "<p class=\"EJ_user_error\"><strong>MODULE ERROR</strong>: Action '".$_REQUEST['action']."' Not Found!</p>";
						}
					break;
				}
			} else
			{
				echo "<p class=\"EJ_user_error\">No Action requested!</p>";
			}
			?>
		</div>
	</div>
	<div id="page_errors"><?=$page_errors?></div>
	<?php EJ_showFooter(); ?>
</div>
</body>
</html>
<?php
}
?>