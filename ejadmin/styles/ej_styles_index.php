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

#container .button
{
	background: url(<?=$EJ_settings['instloc']?>images/buttons.png) no-repeat;
	cursor: pointer;
	display: inline-block;
	height: 100px;
	margin: 15px;
	overflow: hidden;
	text-indent: -1000px;
	width: 100px;
}

#container #logout
{
	background-position: -200px 0;
}

#container #logout:hover
{
	background-position: -200px -100px;
}

#container #settings
{
	background-position: -100px 0;
}

#container #settings:hover
{
	background-position: -100px -100px;
}

#container #modules
{
	background-position: -300px 0;
}

#container #modules:hover
{
	background-position: -300px -100px;
}

#container #profile
{
	background-position: -400px 0;
}

#container #profile:hover
{
	background-position: -400px -100px;
}

#container #uadmin
{
	background-position: 0 0;
}

#container #uadmin:hover
{
	background-position: 0 -100px;
}

#header
{
	background: url(<?=$EJ_settings['instloc']?>images/logo_index.png) no-repeat top right;
}

#module_container {
	background: #CCE0EE;
	border: #42769B 1px solid;
}

#module_container .button {
	cursor: pointer;
	display: inline-block;
	height: 100px;
	margin: 15px;
	overflow: hidden;
	text-indent: -1000px;
	width: 100px;
}

#module_container .button:hover {
	background-position: 0 -100px;
}