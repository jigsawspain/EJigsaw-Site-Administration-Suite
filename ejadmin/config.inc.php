<?php

/*
*** EJ Admin v0.1 - Site Administration
**
*** By Jigsaw Spain - www.jigsawspain.com
**
*** Configuration Settings - File Build 0.1
*/

/*
Please set all settings listed below by replacing anything in curly braces {}, remembering to remove the curly braces when you do so.
*/


/*
** MySQL Settings
*/

/* MySQL Host Name */
$EJ_settings['mysqlhost'] = "localhost";
/* MySQL User Name */
$EJ_settings['mysqluser'] = "root";
/* MySQL Password */
$EJ_settings['mysqlpass'] = "m45ter99";
/* MySQL Database Name */
$EJ_settings['mysqldb'] = "ejigsaw";
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