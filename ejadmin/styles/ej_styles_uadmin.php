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

/* IDs and Classes */

#header
{
	background: url(<?=$EJ_settings['instloc']?>images/logo_uadmin.png) no-repeat top right;
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

#user_table
{
	border-spacing: 0;
	width: 826px;
}

#user_table td
{
	padding: 0 5px;
	vetical-align: middle;
}

#user_table tr.white
{
	background: #FFF;
	color: #42769B;
}

#user_table th
{
	background: #CCE0EE;
	color: #42769B;
	padding: 0 5px;
	text-align: left;
	vartical-align: middle;
}

#user_table thead
{
}

#user_types
{
	float: right;
	width: 150px;
	background: #CCE0EE;
	color: #42769B;
}