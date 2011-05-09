<?php
header("Content-Type: text/css");
require('../config.inc.php');
?>
@charset "utf-8";
/*
*** EJigsaw Site Administration Suite
**
*** By Jigsaw Spain - www.jigsawspain.com
**
*** Uadmin CSS Styles - File Build 0.1
*/

/* Tags */

h2.modulename
{
	background: #E3EEF7;
	border-top: #42769B 1px solid;
	border-bottom: #42769B 1px solid;
	font-size: 1em;
	margin: 5px 0;
	padding: 0 5px;
}

h2 img
{
	vertical-align: middle;
	margin-bottom: 0.2em;
}

/* IDs and Classes */

.module_prof
{
	margin-bottom: 5px;
	padding: 0 5px;
}

#header
{
	background: url(<?=$EJ_settings['instloc']?>images/logo_profile.png) no-repeat top right;
}

.heading
{
	background: #E3EEF7;
	font-weight: bold;
}

#save
{
	font-size: 1.2em;
	margin: 5px;
	width: 250px;
}

.setting
{
	font-weight: bold;
	width: 200px;
}

.small_button.delete
{
	background-position: 0 0;
}

.small_button.delete:hover
{
	background-position: 0 -15px;
}

.small_button.edit
{
	background-position: -15px 0;
}

.small_button.edit:hover
{
	background-position: -15px -15px;
}

.tip
{
	font-size: 0.8em;
	font-style: italic;
}

#user_table
{
	width: 100%;
}

.value
{
	background: #E3EEF7;
	padding: 0 5px;
	width: 240px;
}