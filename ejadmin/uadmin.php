<?php
require_once('init.inc.php');

if ($_SESSION['usertype']<5)
{
	header('location: index.php');
	die();
}

// Retrieve User List
$EJ_mysql->query("SELECT userid, email, type FROM {$EJ_mysql->prefix}users ORDER BY type DESC, userid ASC");
$tablecontent = "";
if ($EJ_mysql->numRows()==0)
	$tablecontent = "<tr><td colspan=\"3\">No Users Found!</td></tr>";
else
{
	while ($EJ_settings['mysqlarray'] = $EJ_mysql->getRow())
	{
		switch ($EJ_settings['mysqlarray']['type']) {
			case 0:
				$type = "Site User";
			break;
			case 1:
				$type = "Moderator";
			break;
			case 5:
				$type = "Admin";
			break;
			case 9:
				$type = "Super-Admin";
			break;
		}
		$tablecontent .= "<tr class=\"white\" id=\"{$EJ_settings['mysqlarray']['userid']}\"><td>{$EJ_settings['mysqlarray']['userid']}</td><td>{$EJ_settings['mysqlarray']['email']}</td><td>$type</td><td>";
		if ($EJ_settings['mysqlarray']['userid']!='admin' and ($_SESSION['usertype']>$EJ_settings['mysqlarray']['type'] or $_SESSION['usertype']==9))
		$tablecontent .= "<a class=\"small_button delete\" href=\"javascript:deleteUser('{$EJ_settings['mysqlarray']['userid']}','{$_SESSION['key']}');\">Delete User</a>";
		if ($_SESSION['usertype']>$EJ_settings['mysqlarray']['type'] or $_SESSION['usertype']==9 or $_SESSION['userid']==$EJ_settings['mysqlarray']['userid'])
		//$tablecontent .= "<a class=\"small_button edit\" href=\"javascript:editUser('{$EJ_settings['mysqlarray']['userid']}','{$_SESSION['key']}');\">Edit User</a>";
		$tablecontent.="</td></tr>";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EJigsaw Site Administration Suite</title>
<link rel="stylesheet" href="styles/ej_styles_main.php" type="text/css" />
<link rel="stylesheet" href="styles/ej_styles_uadmin.php" type="text/css" />
<script src="ajax/EJ_ajax_uadmin.js" language="javascript" type="text/javascript"></script>
</head>

<body>
<div id="frame">
	<div id="header">
		<div id="menu">
			<?php EJ_showMenu(); ?>
		</div>
	</div>
	<div id="content">
		<h1><img src="images/uadmin_small.png" align="User List" /> User List</h1>
		<div id="container">
			<form action="uadmin.php" method="post" name="add_user_form" id="add_user_form">
				<div id="user_types"><p style="height: 17px; text-align: center;"><strong>User Types</strong></p><p style="font-size: 0.8em; margin-bottom: 3px; padding: 0 3px;"><strong>Site User:</strong> Can login to the site but cannot access admin pages or moderation queue</p>
				<p style="font-size: 0.8em; margin-bottom: 3px; padding: 0 3px;"><strong>Moderator:</strong> Can access the site and moderation queue but not the admin pages</p>
				<p style="font-size: 0.8em; margin-bottom: 3px; padding: 0 3px;"><strong>Admin:</strong> Can access the site and all admin pages but cannot add new admins</p><p style="font-size: 0.8em; margin-bottom: 3px; padding: 0 3px;"><strong>Super-Admin:</strong> Full Access to all site functions</p>
				<p style="font-size: 0.8em; margin-bottom: 3px; padding: 0 3px;"><strong>NOTES:</strong></p>
				<p style="font-size: 0.8em; margin-bottom: 3px; padding: 0 3px;">&gt; In order to delete<!--or edit--> another user, the logged in user must be of a greater type than the subject, or a Super-Admin<br>
					&gt; The user 'admin' cannot be deleted for security reasons
				</p>
				</div>
				<table id="user_table">
					<thead>
						<tr>
							<th>
								User Name
							</th>
							<th>
								Email
							Address</th>
							<th>
								User Type
							</th>
							<th>
								Actions
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
						echo $tablecontent ;
						if ($_SESSION['usertype']>0)
						{
						?>
						<tr style="background: #42769B; color: #CCE0EE; font-weight: bold; font-size: 0.8em;" id="end_users">
						<td colspan="4">
								Add New User</td>
						</tr>
						<tr style="background: #CCE0EE; color: #42769B; font-weight: bold; font-size: 0.8em;">
							<td>
								User Name
							</td>
							<td>
								Email
							Address</td>
							<td>
								User Type
							</td>
							<td>
							</td>
						</tr>
						<tr>
							<td>
								<input name="user_id" type="text" id="user_id" value="<?=$_POST['user_id']?>" maxlength="20" style="width:100%; margin: 5px 0;" />
							</td>
							<td>
								<input name="email" type="text" id="email" value="<?=$_POST['email']?>" maxlength="150" style="width:100%; margin: 5px 0;" />
							</td>
							<td>
								<select name="type" id="type" style="width:100%; margin: 5px 0;">
									<option value="0" selected="selected">Site User</option>
									<?php
									if ($_SESSION['usertype']>1)
									{
									?>
									<option value="1"<?=$_POST['type']==1?' selected="selected"':''?>>Moderator</option>
									<?php
									}
									if ($_SESSION['usertype']>5)
									{
									?>
									<option value="5"<?=$_POST['type']==5?' selected="selected"':''?>>Admin</option>
									<option value="9"<?=$_POST['type']==9?' selected="selected"':''?>>Super-Admin</option>
									<?php
									}
									?>
								</select>
							</td>
							<td>
								<input type="hidden" name="key" id="key" value="<?=$_SESSION['key']?>"/>
								<input type="button" name="go" id="go" value="Add User" style="width:100%; margin: 5px 0;" onClick="addUser()"/>
							</td>
						</tr>
						<tr>
							<td colspan="4" style="font-size: 0.8em">
								Password will be automatically generated and emailed to the address provided
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</form>
			<div id="uadmin_errors"></div>
			<div style="clear:right;"></div>
		</div>
	</div>
	<?php EJ_showFooter(); ?>
</div>
</body>
</html>