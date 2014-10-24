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

require_once(t3lib_extMgm::extPath('rn_base') . 'class.tx_rnbase.php');
tx_rnbase::load('tx_mkforms_forms_IJSFramework');


/**
 * Diese Klasse bindet das notwendige Javascript für Prototype/scriptaculous ein.
 *
 */
class tx_mkforms_js_DefaultFramework implements tx_mkforms_forms_IJSFramework {
	private $configurations, $confId;

	public function __construct($configurations, $confId) {
		$this->configurations = $configurations;
		$this->confId = $confId;
	}
	/**
	 * Liefert einen Wert aus der TS-Config
	 *
	 * @param string $confid
	 * @return mixed
	 */
	private function getConf($confid) {
		return $this->configurations->get($this->confId.$confid);
	}
	public function getId() {
		return $this->getConf('jscore');
	}
	public function getBaseIncludes() {
		return $this->loadIncludes('jscore.');
	}
	private function loadIncludes($confId) {
		$server = t3lib_div::getIndpEnv('TYPO3_SITE_URL');

		// TODO: Wir benötigen den Pfad für die URL und den absoluten Serverpfad.
		// Ob das wirklich so ist, muss aber noch geklärt werden: minify und zip
		$jsCore = $this->getConf($confId);
		$ret = array();
		if(!is_array($jsCore)) return $ret;
		foreach ($jsCore As $key => $jsPath) {
			$pagePath = $jsPath;
			if(tx_mkforms_util_Div::isExtensionPath($jsPath))
				$pagePath = tx_mkforms_util_Div::getRelExtensionPath($jsPath);
			$pagePath = $server.$pagePath;
			$serverPath = t3lib_div::getFileAbsFileName($jsPath);
			$ret[] = tx_mkforms_forms_PageInclude::createInstance($pagePath, $serverPath, $key);
		}
		return $ret;
	}
	public function includeBase() {
		
	}
	public function getEffectIncludes() {
		return $this->loadIncludes('effects.');
	}
	public function includeTooltips() {
		
	}
	public function includeDragDrop() {
		
	}
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/util/class.tx_mkforms_js_DefaultFramework.php'])	{
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/util/class.tx_mkforms_js_DefaultFramework.php']);
}
?>