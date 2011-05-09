<?php

/*
*** EJ Admin v0.1 - Site Administration
**
*** By Jigsaw Spain - www.jigsawspain.com
**
*** Configuration Settings
*/

/****
****

IMPORTANT: This file should be re-named to config.inc.php before using the suite

****
****/

/*
Please set all settings listed below by replacing anything in curly braces {}, remembering to remove the curly braces when you do so.
*/


/*
** MySQL Settings
*/

/* MySQL Host Name */
$EJ_settings['mysqlhost'] = "{MySQL Host Name - usually 'localhost'}";
/* MySQL User Name */
$EJ_settings['mysqluser'] = "{MySQL User Name}";
/* MySQL Password */
$EJ_settings['mysqlpass'] = "{MySQL Password}";
/* MySQL Database Name */
$EJ_settings['mysqldb'] = "{MySQL Database Name}";
/* MySQL Table Prefix */
// Change this if you are running more than one instance of the EJigsaw Suite on this server
$EJ_settings['mysqlprefix'] = "EJ_";


/*
** General Settings
*/

/*
*  Install Location
*  This is the location you uploaded the ejadmin files to relative to the site root
*  IMPORTANT: Include leading and trailing slashes
*  e.g. (default and recommended)
*  $EJ_settings['instloc'] = "/ejadmin/";
*/
$EJ_settings['instloc'] = "/ejadmin/";
?>