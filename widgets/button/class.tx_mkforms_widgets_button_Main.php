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

/** 
 * Plugin 'rdt_button' for the 'ameos_formidable' extension.
 *
 * @author	Jerome Schneider <typo3dev@ameos.com>
 */


class tx_mkforms_widgets_button_Main extends formidable_mainrenderlet {
	
	var $sMajixClass = "Button";
	var $aLibs = array(
		"rdt_button_class" => "res/js/button.js",
	);


	function _render() {
		return $this->_renderReadOnly();
	}

	function _renderReadOnly() {
		$sValue = $this->getValue();
		$sLabel = $this->getLabel();
		$sInput = "<input type=\"button\" name=\"" . $this->_getElementHtmlName() . "\" id=\"" . $this->_getElementHtmlId() . "\" value=\"" . htmlspecialchars($sLabel) . "\" " . $this->_getAddInputParams() . " />";

		return array(
			"__compiled" => $sInput,
			"input" => $sInput,
			"label" => $sLabel,
			"value" => $sValue,
		);
	}

	function _renderOnly() {
		return TRUE;
	}
	
	function _readOnly() {
		return TRUE;
	}

	function _activeListable() {		// listable as an active HTML FORM field or not in the lister
		return $this->_defaultTrue("/activelistable/");
	}
}


	if (defined("TYPO3_MODE") && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]["XCLASS"]["ext/ameos_formidable/api/base/rdt_button/api/class.tx_rdtbutton.php"])	{
		include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]["XCLASS"]["ext/ameos_formidable/api/base/rdt_button/api/class.tx_rdtbutton.php"]);
	}

?>