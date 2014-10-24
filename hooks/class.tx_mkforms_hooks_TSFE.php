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


class tx_mkforms_hooks_TSFE {
	function contentPostProc_output() {
		if(isset($GLOBALS['tx_ameosformidable']) && isset($GLOBALS['tx_ameosformidable']['headerinjection'])) {
			
			reset($GLOBALS['tx_ameosformidable']['headerinjection']);
			while(list(, $aHeaderSet) = each($GLOBALS['tx_ameosformidable']['headerinjection'])) {
				$GLOBALS['TSFE']->content = str_replace(
					$aHeaderSet['marker'],
					implode("\n", $aHeaderSet['headers']) . "\n" . $aHeaderSet['marker'],
					$GLOBALS['TSFE']->content
				);
			}
		}
	}
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/hooks/class.tx_mkforms_hooks_TSFE.php'])	{
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/hooks/class.tx_mkforms_hooks_TSFE.php']);
}

?>