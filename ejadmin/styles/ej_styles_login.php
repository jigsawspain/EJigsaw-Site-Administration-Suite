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
	background:	url(<?=$EJ_settings['instloc']?>images/logo_login.png) no-repeat top right;
}

#login_form
{
	background: url(<?=$EJ_settings['instloc']?>images/bg_login_form.png) center center no-repeat;
	color: #FFF;
	height: 130px;
	margin: 30px auto;
	padding: 16px 20px 24px 20px;
	width: 200px;
}

#login_form input
{
	color: #42769B;
	background: #CCE0EE;
	border: 0;
	font-size: 1.3em;
	height: 25px;
	margin-bottom: 5px;
	padding: 0 5px;
	width: 190px;
}

#login_form input.login_button
{
	background: url(<?=$EJ_settings['instloc']?>images/button_200.png) center 0 no-repeat;
	height: 30px;
	padding: 0;
	width: 200px;
}

#login_form input.login_button:hover
{
	background: url(<?=$EJ_settings['instloc']?>images/button_200.png) center -30px no-repeat;
}

#login_form input.login_button:active
{
	background: url(<?=$EJ_settings['instloc']?>images/button_200.png) center -60px no-repeat;
}