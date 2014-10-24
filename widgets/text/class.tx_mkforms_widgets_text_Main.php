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



class tx_mkforms_widgets_text_Main extends formidable_mainrenderlet {
	
	function _render() {

		$sValue = $this->getValue();
		$sLabel = $this->getLabel();
		
		$aAdditionalParams = implode(' ', $this->getAdditionalParams());
		$sInput = '<input type="text" name="' . $this->_getElementHtmlName() . '" id="' . $this->_getElementHtmlId() . '" value="' . $this->getValueForHtml($sValue) . '"' . $this->_getAddInputParams($aAdditionalParams) . ' '.$aAdditionalParams.' />';

		return array(
			"__compiled" => $this->_displayLabel($sLabel) . $sInput,
			"input" => $sInput,
			"label" => $sLabel,
			"value" => $sValue,
		);
	}

	private function getAdditionalParams(){
		$aAdditionalParams = array();
		if(($sMaxLength = $this->_navConf('/maxlength')) !== FALSE) {
			$aAdditionalParams[] = 'maxlength="'.$sMaxLength.'"';
		}
		return $aAdditionalParams;
	}
	
	function getValue() {
		$sValue = parent::getValue();
		if($this->defaultFalse("/convertfromrte/")){
			$aParseFunc["parseFunc."] = $GLOBALS["TSFE"]->tmpl->setup["lib."]["parseFunc_RTE."];
			$sValue = $this->getForm()->getCObj()->stdWrap($sValue, $aParseFunc);
		}
		return $sValue;
	}
	
	function mayHtmlAutocomplete() {
		return TRUE;
	}
}


if (defined("TYPO3_MODE") && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]["XCLASS"]["ext/ameos_formidable/api/base/rdt_text/api/class.tx_mkforms_widgets_text_Text.php"])	{
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]["XCLASS"]["ext/ameos_formidable/api/base/rdt_text/api/class.tx_mkforms_widgets_text_Text.php"]);
}
?>