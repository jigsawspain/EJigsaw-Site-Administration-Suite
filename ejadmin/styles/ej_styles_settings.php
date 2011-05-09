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
*** Login CSS Styles - File Build 0.1
*/

/* IDs and Classes */

#header
{
	background:	url(<?=$EJ_settings['instloc']?>images/logo_settings.png) no-repeat top right;
}

.setting_input
{
	width: 100%;
}

.save_button
{
	color: #42769B;
	border: 0;
	font-size: 1.3em;
	background: url(<?=$EJ_settings['instloc']?>images/button_200.png) center 0 no-repeat;
	height: 30px;
	padding: 0;
	width: 200px;
}

.save_button:hover
{
	background: url(<?=$EJ_settings['instloc']?>images/button_200.png) center -30px no-repeat;
}

.save_button:active
{
	background: url(<?=$EJ_settings['instloc']?>images/button_200.png) center -60px no-repeat;
}

#settings_table
{
	border-spacing: 0;
	width: 100%;
}

#settings_table td
{
	padding: 2px 5px;
	min-width: 200px;
	vertical-align: top;
}

#settings_table tr.white
{
	background: #FFF;
	color: #42769B;
}

#settings_table th
{
	background: #CCE0EE;
	color: #42769B;
	padding: 0 5px;
	text-align: left;
	vartical-align: middle;
}

#settings_table tbody td
{
	border-bottom: #CCE0EE 1px solid;
}

#settings_table tbody td.setting_desc
{
	background: #CCE0EE;
	border-bottom: #42769B 1px solid;
	color: #42769B;
	font-size: 0.8em;
}