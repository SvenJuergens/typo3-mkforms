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
 * Plugin 'act_redct' for the 'ameos_formidable' extension.
 *
 * @author	Jerome Schneider <typo3dev@ameos.com>
 */


class tx_mkforms_action_redirect_Main extends formidable_mainactionlet {

	function _doTheMagic($aRendered, $sForm) {
		if(!$this->getForm()->getDataHandler()->_allIsValid()) {
			return;
		}

		$sUrl = '';
		if(($mPage = $this->_navConf('/pageid')) !== FALSE) {
			$mPage = $this->callRunneable($mPage);
			$sUrl = $this->getForm()->getCObj()->typolink_URL(array('parameter' => $mPage));
			if(!t3lib_div::isFirstPartOfStr($sUrl, 'http://') && trim($GLOBALS['TSFE']->baseUrl) !== '') {
				$sUrl = tx_mkforms_util_Div::removeEndingSlash($GLOBALS['TSFE']->baseUrl) . '/' . $sUrl;
			}
		} else {
			$sUrl = $this->_navConf('/url');
			$sUrl = $this->callRunneable($sUrl);
		}

		if($this->getForm()->isTestMode()){
			return $sUrl;
		}else if(is_string($sUrl) && trim($sUrl) !== '') {
			header('Location: ' . $sUrl);
			exit();
		}
	}
}


if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/action/redirect/class.tx_mkforms_action_redirect_Main.php'])	{
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/action/redirect/class.tx_mkforms_action_redirect_Main.php']);
}

?>