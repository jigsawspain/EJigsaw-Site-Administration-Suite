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
	background:	url(<?=$EJ_settings['instloc']?>images/logo_modules.png) no-repeat top right;
}

#modules_table
{
	border-spacing: 0;
	width: 100%;
}

#modules_table td
{
	padding: 2px 5px;
	vertical-align: top;
}

#modules_table tr.install
{
	background: #FFF;
	color: #CCC;
}

#modules_table tr.white
{
	background: #FFF;
	color: #42769B;
}

#modules_table th
{
	background: #CCE0EE;
	color: #42769B;
	padding: 0 5px;
	text-align: left;
	vartical-align: middle;
}

#modules_table tbody td
{
	border-bottom: #CCE0EE 1px solid;
}

#modules_table tbody td.setting_desc
{
	background: #CCE0EE;
	border-bottom: #42769B 1px solid;
	color: #42769B;
	font-size: 0.8em;
}