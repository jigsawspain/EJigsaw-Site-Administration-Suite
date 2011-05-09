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
*** Main CSS Styles - File Build 0.1
*/

/* Tag Replacements */

*
{
	margin: 0;
	padding: 0;
}

a
{
	color: #CCC;
}

a: visited
{
	color: #CCC;
}

body
{
	background: #E3EEF7 url(<?=$EJ_settings['instloc']?>images/bg_body.png) top left repeat-x;
	color: #42769B;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	height: 100%;
}

h1
{
	background: #CCE0EE;
	border-top: #42769B 1px solid;
	border-right: #42769B 1px solid;
	border-left: #42769B 1px solid;
	display: inline-block;
	font-size: 1.1em;
	margin: 10px 0 -1px 0;
	padding: 0 5px;
}

h1 img
{
	border:0;
	height: 15px;
	margin-bottom: 0.2em;
	vertical-align: middle;
	width: 15px;
}

html
{
	height: 100%;
}

/* IDs and Classes */

#container {
	background: #CCE0EE;
	border: #42769B 1px solid;
}

#content
{
	padding: 25px 0 35px 0;
}

.EJ_Error
{
	color: #F00;
	margin-bottom: 5px;
}

.EJ_user_error
{
	background: #E3EEF7;
	color: #F00;
	margin: 5px;
	padding: 5px;
	text-align: center;
}

.EJ_user_error_list
{
	background: #E3EEF7;
	color: #F00;
	margin: 5px;
	padding: 5px;
	text-align: center;
	list-style-type: none;
}

.EJ_user_message
{
	background: #E3EEF7;
	margin: 5px;
	padding: 5px;
	text-align: center;
}

.EJ_user_success
{
	background: #090;
	color: #E3EEF7;
	margin: 5px;
	padding: 5px;
	text-align: center;
}

.EJ_warning
{
	background: #FFF url(<?=$EJ_settings['instloc']?>images/error.png) top center no-repeat;
	color: #F00;
	margin: 5px;
	padding: 20px 0 0 0;
}

#frame
{
	background: url(<?=$EJ_settings['instloc']?>images/logo_ej.png) no-repeat top left;
	margin: 0 auto;
	position: relative;
	height: auto !important;
	height:100%;
	min-height: 100%;
	width: 1000px;
}

#foot
{
	bottom: 0px;
	font-size: 0.8em;
	position: absolute;
	padding: 0 5px;
	width: 990px;
}

#header
{
	height: 25px;
	padding: 75px 0 0 0;
	margin-left: 227px;
	text-align: right;
}

#menu
{
	font-size: 0.8em;
	height: 25px;
	position: absolute;
	right: 0;
}

.menu
{
	float: right;
	height: 25px;
	margin-left: -1px;
	overflow: hidden;
	text-align: center;
	width: 100px;
	z-index: 99;
}

.menu:hover
{
	height: auto;
	overflow: visible;
}

.menu_button
{
	background: #E3EEF7;
	border-top: #AABAC6 1px solid;
	border-left: #AABAC6 1px solid;
	border-right: #AABAC6 1px solid;
	display: block;
	height: 15px;
	padding: 5px;
	width: 88px;
}

.menu_item
{
	background: #CCE0EE;
	border-top: #E3EEF7 1px solid;
	border-bottom: #9FABB3 1px solid;
	color: #42769B;
	display: block;
	height: 15px;
	text-align: left;
	text-decoration: none;
	padding: 5px;
	position: relative;
	right: 50px;
	width: 140px;
}

.menu_item:hover
{
	background: #AFCFE4;
}

.menu_item img
{
	border:0;
	height: 15px;
	margin-bottom: 0.3em;
	vertical-align: middle;
	width: 15px;
}

.small_button
{
	background: url(<?=$EJ_settings['instloc']?>images/small_buttons.png) no-repeat;
	cursor: pointer;
	display: inline-block;
	height: 15px;
	margin: 1px;
	overflow: hidden;
	text-indent: -1000px;
	width: 15px;
}