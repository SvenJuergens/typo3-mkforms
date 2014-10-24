<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009-2014 DMK E-BUSINESS GmbH (dev@dmk-ebusiness.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


die("DISABLED");
die('<h1>DONT USE THIS!</h1><p>Durch die verwendung verschiedener JavaScript Framework über den MKWrapper (jQuery, Prototype), wurde die Minimierung von Scripten umgestellt!<br /> Das minimierte Script muss sich nun im selben Verzeichniss befinden und .min behinhalten <br /> framework.js - framework.min.js</p>');
error_reporting(E_ALL);
require_once("minify.php");
$oMin = new Minify(TYPE_JS);

$aJs = array();
$aJs[] = file_get_contents(realpath('../jsfwk/prototype/prototype.js'));
$aJs[] = file_get_contents(realpath('../jsfwk/prototype/addons/lowpro/lowpro.js'));
$aJs[] = file_get_contents(realpath('../jsfwk/prototype/addons/base/Base.js'));
$aJs[] = file_get_contents(realpath('../jsfwk/json/json.js'));
$aJs[] = file_get_contents(realpath('../jsfwk/framework.js'));


header("Content-Type: text/javascript;charset=utf-8");

$sNotice =<<<NOTICE
/*
	NOTE: THIS IS MINIFIED VERSION OF FORMIDABLE JS
	For regular set typoscript: config.tx_mkforms.minify.enabled=0
*/
NOTICE;
if(isset($_GET) && is_array($_GET) && array_key_exists("plain", $_GET) && $_GET["plain"] == 1) {
	echo implode($aJs, "");
} else {
	echo $sNotice . $oMin->minifyJS(implode($aJs, ""));	
}

exit;

?>
