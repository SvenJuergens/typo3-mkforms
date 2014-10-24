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
 * Plugin 'rdt_txtarea' for the 'ameos_formidable' extension.
 *
 * @author	Jerome Schneider <typo3dev@ameos.com>
 */
tx_rnbase::load('tx_mkforms_js_Loader');


class tx_mkforms_widgets_txtarea_Main extends formidable_mainrenderlet {
	
	function _render() {
		
		$sValue = $this->getValue();
		$sLabel = $this->getLabel();
		$sValue = $this->oForm->getConfigXML()->getLLLabel($sValue);
		
		$sAddInputParams = $this->_getAddInputParams();
		

		/* adaptation for XHTML1.1 strict validation */

		if(strpos($sAddInputParams, 'rows') === FALSE) {
			$sAddInputParams = ' rows="2" ' . $sAddInputParams;
		}

		if(strpos($sAddInputParams, 'cols') === FALSE) {
			$sAddInputParams = ' cols="20" ' . $sAddInputParams;
		}
		
		// sollen in der textarea durch das jQuery autoresize Plugin
		// die evtl. anfallenden scroll balken entfernt werden
		// es gibt nur eine Unterstützung für jQuery!!!
		if($this->getForm()->getJSLoader()->getJSFrameworkId() == 'jquery' && $this->defaultFalse('/autoresize')){
			$this->sMajixClass = "TxtArea";
			$this->bCustomIncludeScript = true;
			$this->aLibs["rdt_autoresize_class"] = "res/js/autoresize.min.js";
			$this->aLibs["rdt_txtarea_class"] = "res/js/txtarea.js";
			//damit im JS bekannt ist, ob autoresize gesetzt ist
			$this->includeScripts(array('autoresize' => $this->defaultFalse('/autoresize')));
		}

		/* */
		
		$sValueForHtml = $this->getValueForHtml($sValue);
		$sInput = '<textarea name="' . $this->_getElementHtmlName() . '" id="' . $this->_getElementHtmlId() . '"' . $sAddInputParams . '>' . $sValueForHtml . '</textarea>';
		
		
		
		return array(
			'__compiled' => $this->_displayLabel($sLabel) . $sInput,
			'input' => $sInput,
			'label' => $sLabel,
			'value' => $sValue,
		);
	}
	
	function _getHumanReadableValue($sValue) {
		return nl2br(htmlspecialchars($sValue));
	}
}


if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/widgets/txtarea/class.tx_mkforms_widgets_txtarea_Main.php'])	{
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/widgets/txtarea/class.tx_mkforms_widgets_txtarea_Main.php']);
}
?>