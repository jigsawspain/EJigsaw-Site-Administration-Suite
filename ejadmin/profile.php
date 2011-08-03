<?php
require_once('init.inc.php');


// Retrieve User Details
$EJ_mysql->query("SELECT email FROM {$EJ_mysql->prefix}users WHERE userid = '{$_SESSION['userid']}'");
$user = $EJ_mysql->getRow();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EJigsaw Site Administration Suite</title>
<link rel="stylesheet" href="styles/ej_styles_main.php" type="text/css" />
<link rel="stylesheet" href="styles/ej_styles_profile.php" type="text/css" />
<script src="ajax/EJ_ajax_profile.js" language="javascript" type="text/javascript"></script>
</head>

<body>
<div id="frame">
	<div id="header">
		<div id="menu">
			<?php EJ_showMenu(); ?>
		</div>
	</div>
	<div id="content">
		<h1><img src="images/profile_small.png" alt="Your Profile" /> Your Profile</h1>
		<div id="container">
			<form action="profile.php" method="post" name="profile_form" id="profile_form">
				<table id="user_table">
					<tbody>
						<tr>
							<td class="setting">User Name</td><td class="value"><?=$_SESSION['userid']?></td><td class="tip">This cannot be changed</td>
						</tr>
						<tr>
							<td class="setting">Contact Email</td><td class="value"><input type="text" name="email" id="email" value="<?=$user['email']?>"/></td><td class="tip">The email addres we send updates and important messages to.</td>
						</tr>
						<tr>
							<td class="heading" colspan="3">Change Password</td>
						</tr>
						<tr>
							<td class="setting">New Password</td><td class="value"><input type="password" name="newpass" id="newpass" value="<?=$_POST['newpass']?>" autocomplete="off"/></td><td class="tip">Min. 8 characters.</td>
						</tr>
						<tr>
							<td class="setting">Confirm New Password</td><td class="value"><input type="password" name="confpass" id="confpass" value="<?=$_POST['confpass']?>" autocomplete="off"/></td><td class="tip">Must match above password.</td>
						</tr>
						<tr>
							<td class="heading" colspan="3" style="text-align: center"><input type="button" name="save" id="save" value="Save Profile/Password" onClick="saveProfile('<?=$_SESSION['key']?>')"/></td>
						</tr>
					</tbody>
				</table>
			</form>
			<div id="profile_errors"></div>
			<div style="clear:right;"></div>
		</div>
			<?php
			if (count($EJ_modules)!=0)
			{
				foreach($EJ_modules as $mod)
				{
					$modname = $mod['moduleid'];
					$module = new $modname(NULL, NULL, NULL);
					if (method_exists($module,'profile_page'))
					{
						$modules[$modname]['name'] = $module->name;
					}
				}
				if (count($modules)!=0)
				{
				?>
		<h1><img src="images/modules_small.png" alt="Module Profile Settings" /> Module Profile Settings</h1>
		<div id="container" class="modules">
			<?php
				foreach ($modules as $id => $mod)
				{
					if (file_exists('modules/'.$id.'/icon.png')) $img = ' <img src="modules/'.$id.'/icon.png" alt="'.$mod['name'].'" /> ';
					else $img = '';
					?>
					<h2 class="modulename"><?=$img?><?=$mod['name']?></h2>
					<div id="<?=$id?>" class="module_prof">
						<?php
						$module = new $id($EJ_mysql, $_REQUEST, $EJ_settings);
						$module->profile_page();
						?>
					</div>
					<?php
				}
			?>
		</div>
				<?php
				}
			}
			?>
	</div>
	<?php EJ_showFooter(); ?>
</div>
</body>
</html>