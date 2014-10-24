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


	class tx_ameosformidable_pi extends tslib_pibase {

		var $extKey = 'ameos_formidable';
		var $oForm = FALSE;
		var $aFormConf = FALSE;
		var $sXmlPath = FALSE;

		function main($content, $conf) {
			$this->conf = $conf;
			$this->pi_setPiVarDefaults();
			$this->pi_loadLL();

			$sConfPath = trim($this->pi_getFFvalue(
				$this->cObj->data['pi_flexform'],
				'tspath'
			));

			require_once(PATH_formidableapi);

			if($sConfPath !== "") {

				$aCurZone =& $GLOBALS["TSFE"]->tmpl->setup;

				$aPath = explode(".", $sConfPath);
				reset($aPath);
				while(list(, $sSegment) = each($aPath)) {
					if(array_key_exists($sSegment . ".", $aCurZone)) {
						$aCurZone =& $aCurZone[$sSegment . "."];
					} else {
						return "<strong>Formidable: TS path not found in template</strong>";
					}
				}

				$this->aFormConf = $aCurZone;
			} else {

				$sConfPath = trim($this->pi_getFFvalue(
					$this->cObj->data['pi_flexform'],
					'xmlpath'
				));

				if($sConfPath !== "") {
					$this->sXmlPath = tx_ameosformidable::toServerPath($sConfPath);
				} else {
					if(array_key_exists("xmlpath", $this->conf)) {
						$this->sXmlPath = tx_ameosformidable::toServerPath($this->conf["xmlpath"]);
					} else {
						return "<strong>Formidable: TS or XML pathes not defined</strong>";
					}
				}
			}

			return TRUE;
		}

		function render() {
			// init+render

			require_once(t3lib_extMgm::extPath('mkforms') . "api/class.tx_ameosformidable.php");
			$this->oForm = t3lib_div::makeInstance("tx_ameosformidable");
			if($this->sXmlPath === FALSE) {
				$this->oForm->initFromTs(
					$this,
					$this->aFormConf
				);
			} else {
				$this->oForm->init(
					$this,
					$this->sXmlPath
				);
			}

			return $this->pi_wrapInBaseClass($this->oForm->render());
		}
	}

	if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/ameos_formidable/api/class.tx_ameosformidable_pi.php']) {
		include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/ameos_formidable/api/class.tx_ameosformidable_pi.php']);
	}
?>