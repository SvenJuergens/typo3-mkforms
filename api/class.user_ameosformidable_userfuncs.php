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


class user_ameosformidable_userfuncs {
	function getAdditionalHeaderData() {
		
		$aRes = array();
		if(isset($GLOBALS["tx_ameosformidable"]) && isset($GLOBALS["tx_ameosformidable"]["headerinjection"])) {
			
			reset($GLOBALS["tx_ameosformidable"]["headerinjection"]);
			while(list(, $aHeaderSet) = each($GLOBALS["tx_ameosformidable"]["headerinjection"])) {
				$aRes[] = implode("\n", $aHeaderSet["headers"]);
			}
		}

		reset($aRes);
		return implode("", $aRes);
	}
}

if (defined("TYPO3_MODE") && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]["XCLASS"]["ext/ameos_formidable/api/class.user_ameosformidable_userfuncs.php"])	{
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]["XCLASS"]["ext/ameos_formidable/api/class.user_ameosformidable_userfuncs.php"]);
}

?>