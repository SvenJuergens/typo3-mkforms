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


require_once(t3lib_extMgm::extPath('mkforms') . "api/class.mainscriptingmethods.php");

class formidable_inlineconfmethods extends formidable_mainscriptingmethods {

	function &method_this(&$oRdt, $aParams) {
		return $oRdt;
	}
	
	function &method_parent(&$oRdt, $aParams) {
		
		if($this->oForm->isRenderlet($oRdt)) {
			if($oRdt->hasParent()) {
				return $oRdt->oRdtParent;
			}
		}

		return AMEOSFORMIDABLE_LEXER_BREAKED;
	}
	
	function &method_brother(&$oRdt, $aParams) {
		if($this->oForm->isRenderlet($oRdt)) {
			$oParent =& $this->method_parent($oRdt, $aParams);
			if($this->oForm->isRenderlet($oParent)) {
				return $this->method_child(
					$oParent,
					$aParams
				);
			}
		}
		
		return AMEOSFORMIDABLE_LEXER_BREAKED;
	}
	
	function method_getAbsName(&$oRdt, $aParams) {
		
		if($this->oForm->isRenderlet($oRdt)) {
			return $oRdt->getAbsName();
		}
		
		return AMEOSFORMIDABLE_LEXER_BREAKED;
	}
	
	function &method_child(&$oRdt, $aParams) {
		if($this->oForm->isRenderlet($oRdt)) {
			if($oRdt->hasChilds()) {
				if(array_key_exists($aParams[0], $oRdt->aChilds)) {
					return $oRdt->aChilds[$aParams[0]];
				}
			}
		}
		
		return AMEOSFORMIDABLE_LEXER_BREAKED;
	}
	
	function &method_rdt($oRdt, $aParams) {
		return $this->oForm->rdt($aParams[0]);
	}
}

?>
