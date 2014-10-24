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

	/*
		Handles TS content objects FORMIDABLE (cached) and FORMIDABLE_INT (not cached)
	*/

	class user_ameosformidable_cobj {
		
		function cObjGetSingleExt($name, $conf, $TSkey, &$oCObj) {
			
			$content = "";
			
			switch($name) {
				case "FORMIDABLE_INT": {
					
					$substKey = "INT_SCRIPT." . $GLOBALS['TSFE']->uniqueHash();
					$content .= "<!--" . $substKey . "-->";

					$GLOBALS["TSFE"]->config["INTincScript"][$substKey] = array(
						"file" => $incFile,
						"conf" => $conf,
						"cObj" => serialize($this),
						"type" => "POSTUSERFUNC",	// places a flag to call callUserFunction() later on serialized object $this, precisely in $GLOBALS["TSFE"]->INTincScript()
					);

					break;
				}
				case "FORMIDABLE": {
					
					$content .= $this->_render($conf);

					if($GLOBALS["TSFE"]->cObj->checkIf($conf["if."])) {				
						if($conf["wrap"]) {
							$content = $GLOBALS["TSFE"]->cObj->wrap($content, $conf["wrap"]);
						}

						if($conf["stdWrap."]) {
							$content = $GLOBALS["TSFE"]->cObj->stdWrap($content, $conf["stdWrap."]);
						}
					}

					break;
				}
			}

			return $content;
		}

		function callUserFunction($postUserFunc, $conf, $content) {

			$content .= $this->_render($conf);

			if($GLOBALS["TSFE"]->cObj->checkIf($conf["if."])) {				
				if($conf["wrap"]) {
					$content = $GLOBALS["TSFE"]->cObj->wrap($content, $conf["wrap"]);
				}

				if($conf["stdWrap."]) {
					$content = $GLOBALS["TSFE"]->cObj->stdWrap($content, $conf["stdWrap."]);
				}
			}

			return $content;
		}

		function _render($conf) {
			
			require_once(t3lib_extMgm::extPath('mkforms') . "api/class.tx_ameosformidable.php");
			$this->oForm = t3lib_div::makeInstance("tx_ameosformidable");
			$this->oForm->initFromTs(
				$this,
				$conf
			);

			return $this->oForm->render();
		}
	}

	if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/api/class.user_ameosformidable_cobj.php']) {
		include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/api/class.user_ameosformidable_cobj.php']);
	}

?>