<?php
require_once('init.inc.php');

if ($_SESSION['usertype']<5)
{
	header('location: index.php');
	die();
}

if (isset($_POST['save'])) {
	foreach ($_POST as $setting => $value)
	{
		$EJ_settings['queries'][] = "UPDATE {$EJ_mysql->prefix}settings SET value = '$value' WHERE setting = '$setting'";
		$EJ_settings[$setting] = $value;
	}
	foreach($EJ_settings['queries'] as $query)
	{
		error_reporting(E_ALL);
		if (!$EJ_mysql->query($query)) EJ_error(31);
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EJigsaw Site Administration Suite</title>
<link rel="stylesheet" href="styles/ej_styles_main.php" type="text/css" />
<link rel="stylesheet" href="styles/ej_styles_settings.php" type="text/css" />
</head>

<body>
<div id="frame">
	<div id="header">
		<div id="menu">
			<?php EJ_showMenu(); ?>
		</div>
	</div>
	<div id="content">
		<h1><img src="images/settings_small.png" alt="Site Settings" /> Site Settings</h1>
		<div id="container">
			<form name="settings_form" id="settings_form" action="settings.php" method="post">
				<table id="settings_table">
					<thead>
						<tr>
							<th>
								Setting Name
							</th>
							<th>
								Current Value
							</th>
							<th>
								Description
							</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$EJ_mysql->query("SELECT setting, name, value, `desc` FROM {$EJ_mysql->prefix}settings WHERE editable = 1");
					while ($EJ_settings['mysqlarray']=$EJ_mysql->getRow())
					{
					?>
						<tr class="white">
							<td>
								<?=$EJ_settings['mysqlarray']['name']?>
							</td>
							<td>
								<input type="text" class="setting_input" name="<?=$EJ_settings['mysqlarray']['setting']?>" id="<?=$EJ_settings['mysqlarray']['setting']?>" value="<?=$EJ_settings[$EJ_settings['mysqlarray']['setting']]?>" maxlength="150" />
							</td>
							<td class="setting_desc">
								<?=$EJ_settings['mysqlarray']['desc']?>
							</td>
						</tr>
					<?php
					}
					?>
						<tr class="white">
							<td>
							</td>
							<td>
								<input type="submit" class="save_button" name="save" id="save" value="Save" />
							</td>
							<td class="setting_desc" style="border-bottom: 0;">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
	<?php EJ_showFooter(); ?>
</div>
</body>
</html>