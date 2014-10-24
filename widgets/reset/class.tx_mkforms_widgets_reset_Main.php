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
 * Plugin 'rdt_submit' for the 'ameos_formidable' extension.
 *
 * @author	Jerome Schneider <typo3dev@ameos.com>
 */


class tx_mkforms_widgets_reset_Main extends formidable_mainrenderlet {
	
	function _render() {
		// return "<input type=\"button\" name=\"" . $this->_getElementHtmlName() . "\" id=\"" . $this->_getElementHtmlId() . "\" value=\"" . $this->oForm->getConfigXML()->getLLLabel($this->_navConf("/label")) . "\"" . $this->_getAddInputParams() . " />";
		$sLabel = $this->getLabel();

		if(($sPath = $this->_navConf('/path')) !== FALSE) {
			$sPath = $this->getForm()->getRunnable()->callRunnableWidget($this, $sPath);
			$sPath = $this->oForm->toWebPath($sPath);
			$sHtml = '<input type="image" name="' . $this->_getElementHtmlName() . '" id="' . $this->_getElementHtmlId() . '" value="' . $sLabel . "\" src=\"" . $sPath . "\"" . $this->_getAddInputParams() . " />";
		} else {
			$sHtml = '<input type="reset" name="' . $this->_getElementHtmlName() . '" id="' . $this->_getElementHtmlId() . '" value="' . $sLabel . "\"" . $this->_getAddInputParams() . " />";
		}

		return $sHtml;
	}


	function _searchable() {
		return $this->_defaultFalse('/searchable/');
	}

	function _renderOnly() {
		return TRUE;
	}
}


if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/widgets/submit/class.tx_mkforms_widgets_submit_Main.php'])	{
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/widgets/submit/class.tx_mkforms_widgets_submit_Main.php']);
}
?>