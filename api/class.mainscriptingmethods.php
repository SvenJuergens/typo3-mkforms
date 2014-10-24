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


class formidable_mainscriptingmethods {
	
	function _init(&$oForm) {
		$this->oForm =& $oForm;		
	}
	
	function process($sMethod, $mData, $sArgs) {

		$aParams = $this->oForm->getTemplateTool()->parseTemplateMethodArgs($sArgs);
		$sMethodName = strtolower('method_' . $sMethod);

		if(method_exists($this, $sMethodName)) {
			return $this->$sMethodName($mData,$aParams);
		} else {
			if(is_object($mData) && is_string($sMethod) && method_exists($mData, $sMethod)) {
				return $mData->{$sMethod}($aParams,$this->oForm);
			}	
		}

		return AMEOSFORMIDABLE_LEXER_FAILED;
	}
		
} // END class formidable_mainscriptingmethods
