<?php
/**
 *  Copyright notice
 *
 *  (c) 2011 Michael Wagner <michael.wagner@das-medienkombinat.de>
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
require_once(t3lib_extMgm::extPath('rn_base', 'class.tx_rnbase.php'));
tx_rnbase::load('tx_mkforms_util_FormBase');
tx_rnbase::load('tx_mkforms_tests_Util');

/**
 * @package tx_mkforms
 * @subpackage tx_mkforms_tests_util
 */
class tx_mkforms_tests_util_FormBase_testcase extends tx_phpunit_testcase {


	/**
	 * @group unit
	 */
	public function testGetItemsFromDb() {
		$formBase = $this->getMockClass(
			'tx_mkforms_util_FormBase', array('getRowsFromDataBase')
		);
		$form = tx_mkforms_tests_Util::getForm();
		$formBase::staticExpects($this->once())
			->method('getRowsFromDataBase')
			->with(array('someParams'), $form)
			->will($this->returnValue(
				array(
					0 => array(
						'__value__' => 123, '__caption__' => 'first'
					),
					1 => array(
						'__value__' => 456, '__caption__' => 'second'
					),
				)
			));

		$this->assertEquals(
			array(
				0 => array('value' => 123, 'caption' => 'first'),
				1 => array('value' => 456, 'caption' => 'second'),
			),
			$formBase::getItemsFromDb(array('someParams'), $form),
			'rückgabe falsch'
		);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mkforms/tests/util/class.tx_mkforms_tests_util_Div_testcase.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mkforms/tests/util/class.tx_mkforms_tests_util_Div_testcase.php']);
}