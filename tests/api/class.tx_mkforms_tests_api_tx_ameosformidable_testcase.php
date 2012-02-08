<?php
/**
 * 	@package tx_mkforms
 *  @subpackage tx_mkforms_tests_api
 *  @author Hannes Bochmann
 *
 *  Copyright notice
 *
 *  (c) 2010 Hannes Bochmann <hannes.bochmann@das-medienkombinat.de>
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
 */

/**
 * benötigte Klassen einbinden
 */
require_once(t3lib_extMgm::extPath('rn_base') . 'class.tx_rnbase.php');
tx_rnbase::load('tx_mkforms_tests_Util');

/**
 * Testfälle für tx_mkforms_api_mainrenderlet
 * wir testen am beispiel des TEXT widgets
 *
 * @author hbochmann
 * @package tx_mkforms
 * @subpackage tx_mkforms_tests_filter
 */
class tx_mkforms_tests_api_tx_ameosformidable_testcase extends tx_phpunit_testcase {

	/**
	 * 
	 * @expectedException RuntimeException
	 */
	public function testRenderThrowsExceptionIfRequestTokenIsNotSet() {
		$_POST['radioTestForm']["AMEOSFORMIDABLE_SUBMITTED"] = AMEOSFORMIDABLE_EVENT_SUBMIT_FULL;
		$oForm = tx_mkforms_tests_Util::getForm()->render();
	}
	
	/**
	 * 
	 * @expectedException RuntimeException
	 */
	public function testRenderThrowsExceptionIfRequestTokenIsInvalid() {
		$_POST['radioTestForm']["AMEOSFORMIDABLE_SUBMITTED"] = AMEOSFORMIDABLE_EVENT_SUBMIT_FULL;
		$_POST['radioTestForm']['MKFORMS_REQUEST_TOKEN'] = 'iAmInvalid';
		$oForm = tx_mkforms_tests_Util::getForm()->render();
	}
	
	/**
	 */
	public function testRenderThrowsNoExceptionIfRequestTokenIsValid() {
		$_POST['radioTestForm']["AMEOSFORMIDABLE_SUBMITTED"] = AMEOSFORMIDABLE_EVENT_SUBMIT_FULL;
		//damit wir getCsrfProtectionToken aufrufen können
		$oForm = tx_mkforms_tests_Util::getForm();
		$_POST['radioTestForm']['MKFORMS_REQUEST_TOKEN'] = $oForm->getCsrfProtectionToken();
		
		//jetzt die eigentliche initialisierung
		$oForm = tx_mkforms_tests_Util::getForm();
		
		$this->assertContains(
			'<input type="hidden" name="radioTestForm[MKFORMS_REQUEST_TOKEN]" id="radioTestForm_MKFORMS_REQUEST_TOKEN" value="'.$oForm->getCsrfProtectionToken().'" />', 
			$oForm->render(),
			'Es ist nicht der richtige request token enthalten!'
		);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mkforms/tests/api/class.tx_mkforms_tests_api_mainvalidator_testcase.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mkforms/tests/api/class.tx_mkforms_tests_api_mainvalidator_testcase.php']);
}

?>