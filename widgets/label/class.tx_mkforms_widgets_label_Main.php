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
 * Plugin 'rdt_lbl' for the 'ameos_formidable' extension.
 *
 * @author	Jerome Schneider <typo3dev@ameos.com>
 */


class tx_mkforms_widgets_label_Main extends formidable_mainrenderlet {
	
	function _renderReadOnly() {

		$aItems = $this->_getItems();
		$value = $this->oForm->oDataHandler->getThisFormData($this->_getName());

		$sCaption = $value;

		if(count($aItems) > 0) {

			reset($aItems);
			while(list($itemindex, $aItem) = each($aItems))
			{
				if($aItem["value"] == $value) {
					$sCaption = $aItem["caption"];
				}
			}
		}

		$sCaption = htmlspecialchars($this->oForm->getConfigXML()->getLLLabel($sCaption));

		return $sCaption;
	}
	
	function _renderOnly() {
		return TRUE;
	}

	function _readOnly() {
		return TRUE;
	}
}


if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/ameos_formidable/api/base/rdt_lbl/api/class.tx_rdtlbl.php"])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/ameos_formidable/api/base/rdt_lbl/api/class.tx_rdtlbl.php"]);
}

