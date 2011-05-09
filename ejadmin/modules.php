<?php
require_once('init.inc.php');

if ($_SESSION['usertype']<5)
{
	header('location: index.php');
	die();
}

// Check for and verify existing Modules

// error_reporting(E_ALL);

$EJ_modules = array();
ob_start();
$EJ_mysql->query("SELECT * FROM {$EJ_mysql->prefix}modules ORDER BY name");
$page_errors .= ob_get_contents();
ob_end_clean();
if ($EJ_mysql->numRows()!=0)
{
	while ($mod = $EJ_mysql->getRow())
	{
		$EJ_modules[$mod['moduleid']] = $mod;
	}
	foreach ($EJ_modules as $id => $data) {
		if (file_exists('modules/ej_module_'.$id.'.php'))
		{
			if (class_exists($id)) {
				$EJ_modules[$id]['found']=1;
				ob_start();
				$module = new $id();
				ob_end_clean();
				$currversion = number_format(str_replace(".","",$data['version']));
				$thisversion = number_format(str_replace(".","",$module->version));
				if($thisversion < $currversion)
				{
					$EJ_modules[$id]['version'] .= " <img src=\"images/error.png\" alt=\"Error!\" title=\"Error: Old Version Found! (".$module->version.")\">";
				} elseif ($thisversion > $currversion)
				{
					$EJ_modules[$id]['version'] .= " <a href=\"javascript:update_module('$id', '{$EJ_modules[$id]['name']}', {$EJ_modules[$id]['version']})\"><img src=\"images/upgrade.png\" alt=\"Update\" title=\"Update Available\" /></a>";
				}
				unset($module);
			}
		} else
		{
			$EJ_modules[$id]['found']=0;
		}
	}
}

// Check for new Modules and check basic compliance

$directory = opendir('modules/');
while ($file = readdir($directory)) {
	if (substr($file,0,10)=="ej_module_") {
		$id = explode(".",$file);
		$id = substr($id[0],10);
		if (!isset($EJ_modules[$id])) {
			ob_start();
			require_once('modules/'.$file);
			$page_errors .= ob_get_contents();
			ob_end_clean();
			if (class_exists($id))
			{
				$module = new $id(NULL,NULL,NULL);
				if (isset($module->version) and method_exists($module, 'install') and method_exists($module, 'uninstall') and method_exists($module, 'update') and !method_exists($module, '__construct') and !method_exists($module, '__destruct') and class_exists($id))
				{
					$EJ_modules[$id]['moduleid'] = $id;
					$EJ_modules[$id]['version'] = $module->version;
					if (isset($module->creator))
						$EJ_modules[$id]['creator'] = $module->creator;
					else
						$EJ_modules[$id]['creator'] = "Unknown!";
					if (isset($module->name))
						$EJ_modules[$id]['name'] = $module->name;
					else
						$EJ_modules[$id]['name'] = $id;
					$EJ_modules[$id]['verified'] = 0;
					$EJ_modules[$id]['install'] = 1;
				}
				unset($module);
			}
		}
	}
}
closedir($directory);

// Process module/page actions

if (isset($_REQUEST['module']))
{
	if ($_REQUEST['key']!=$_SESSION['key'])
	{
		ob_start();
		EJ_error(12);
		$page_errors .= ob_get_contents();
		ob_end_clean();
	} else
	{
		if ($EJ_modules[$_REQUEST['module']]['found']!=1 and $EJ_modules[$_REQUEST['module']]['install']!=1)
		{
			ob_start();
			EJ_error(40);
			$page_errors .= ob_get_contents();
			ob_end_clean();
		} else
		{
			$id = $_REQUEST['module'];
			$_vars = $_REQUEST;
			unset($_vars['PHPSESSID']);
			$module = new $id($EJ_mysql, $_vars);
			switch (strtolower($_REQUEST['action']))
			{
				case 'install':
					ob_start();
					if ($module->install())
					{
						unset($EJ_modules[$id]['install']);
						$EJ_modules[$id]['found']=1;
					} else
					{
						echo "<p class=\"EJ_user_error\"><strong>ERROR</strong>: Install Failed!<br/>Please contact creator or Jigsaw Support</p>";
					}
					$module_output = ob_get_contents();
					ob_end_clean();
				break;
				case 'uninstall':
					ob_start();
					if ($module->uninstall())
					{
						unset($EJ_modules[$id]['found']);
						$EJ_modules[$id]['install']=1;
					} else
					{
						echo "<p class=\"EJ_user_error\"><strong>ERROR</strong>: Uninstall Failed!<br/>Please contact creator or Jigsaw Support</p>";
					}
					$module_output = ob_get_contents();
					ob_end_clean();
				break;
				case 'update':
					ob_start();
					$module->update();
					$module_output = ob_get_contents();
					ob_end_clean();
				break;
				default :
					$page_errors .= "	<p class=\"EJ_user_error\">
			<strong>MODULE ERROR</strong>: Requested action is not allowed here<br/>
			Action: ".$_REQUEST['action'];
				break;
			}
		}
	}
}


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EJigsaw Site Administration Suite</title>
<link rel="stylesheet" href="styles/ej_styles_main.php" type="text/css" />
<link rel="stylesheet" href="styles/ej_styles_modules.php" type="text/css" />
<script language="javascript" type="text/javascript" src="ajax/approval.js"></script>
<script language="javascript" type="text/javascript">
function install_module(moduleId, moduleName)
{
	if (confirm('Are you sure you want to install "'+moduleName+'" ('+moduleId+')?'))
	{
		document.location = "modules.php?module="+moduleId+"&action=install&key=<?=$_SESSION['key']?>";
	}
}

function uninstall_module(moduleId, moduleName)
{
	if (confirm('Uninstall will remove all data and settings for this module.\n\nAre you sure you want to uninstall "'+moduleName+'" ('+moduleId+')?'))
	{
		document.location = "modules.php?module="+moduleId+"&action=uninstall&key=<?=$_SESSION['key']?>";
	}
}

function update_module(moduleId, moduleName, oldVersion)
{
	if (confirm('Are you sure you want to update "'+moduleName+'" ('+moduleId+')?'))
	{
		document.location = "modules.php?module="+moduleId+"&action=update&oldversion="+oldVersion+"&key=<?=$_SESSION['key']?>";
	}
}
</script>
</head>

<body>
<div id="frame">
	<div id="header">
		<div id="menu">
			<?php EJ_showMenu(); ?>
		</div>
	</div>
	<div id="content">
		<h1><img src="images/modules_small.png" alt="Modules" /> Modules</h1>
		<div id="container">
				<table id="modules_table">
					<thead>
						<tr>
							<th>
								Module Name
							</th>
							<th>
								Module ID
							</th>
							<th>
								Version
							</th>
							<th>
								Creator
							</th>
							<th>
								Verification
							</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if (count($EJ_modules)==0)
					{
						?>
						<tr class="white">
							<td colspan="5">
								No External Modules Found.
							</td>
						</tr>
						<?php
					} else
					{
						foreach ($EJ_modules as $id => $data)
						{
						?>
						<tr <?=$data['install']==1 ? 'class="install"' : 'class="white"'?>>
							<td>
								<?php 
								if (file_exists('modules/'.$id.'/icon.png'))
									echo "<img src=\"modules/".$id."/icon.png\" alt=\"\" title=\"".$data['name']."\" /> ";
								elseif (file_exists('modules/'.$id.'/icon.gif'))
									echo "<img src=\"modules/".$id."/icon.gif\" alt=\"\" title=\"".$data['name']."\" /> ";
								elseif (file_exists('modules/'.$id.'/icon.jpg'))
									echo "<img src=\"modules/".$id."/icon.jpg\" alt=\"\" title=\"".$data['name']."\" /> ";
								echo $data['name'];
								?>
							</td>
							<td>
								<?=$data['moduleid']?>
							</td>
							<td>
								<?=$data['version']?>
							</td>
							<td>
								<?=$data['creator']?>
							</td>
							<td>
								<?php
								if ($data['install']==1) 
								{
									echo '<a href="javascript:install_module(\''.$data['moduleid'].'\', \''.$data['name'].'\')">Install</a>';
								} else
								{
									if ($data['found']==1)
									{
										echo '<div style="float: right;"><a href="javascript:uninstall_module(\''.$data['moduleid'].'\', \''.$data['name'].'\')">Uninstall</a></div><img src="images/verified.png" alt="Found" title="Module Found" />';
									} else
									{
										echo '<img src="images/cross.png" alt="Module Not Found!" title="Module Not Found or Incomplete!" />';
									}
								}
								if ($data['verified']==1)
								{
									echo '<img src="images/approved.png" alt="Approved" title="Module Approved by EJigsaw Admin" />';
								}
								?>
							</td>
						</tr>
						<?php
						}
					}
					?>
					</tbody>
				</table>
		</div>
		<div id="page_errors"><?=$page_errors?></div>
		<div id="module_status"><?=$module_output?></div>
	</div>
	<?php EJ_showFooter(); ?>
</div>
</body>
</html>