<?php
/**
 * @package tx_mkforms
 * @subpackage tx_mkforms_tests_api
 * @author Hannes Bochmann
 *
 *  Copyright notice
 *
 *  (c) 2010 Hannes Bochmann <dev@dmk-business.de>
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
require_once(tx_rnbase_util_Extensions::extPath('mkforms') . 'api/class.mainobject.php');
require_once(tx_rnbase_util_Extensions::extPath('mkforms') . 'api/class.mainrenderer.php');
tx_rnbase::load('tx_mkforms_tests_Util');
require_once(tx_rnbase_util_Extensions::extPath('phpunit').'Classes/Framework.php');
tx_rnbase::load('tx_rnbase_tests_BaseTestCase');
tx_rnbase::load('tx_mkforms_tests_Util');

/**
 * Testfälle für tx_mkforms_api_mainrenderlet
 * wir testen am beispiel des TEXT widgets
 *
 * @author hbochmann
 * @package tx_mkforms
 * @subpackage tx_mkforms_tests_filter
 */
class tx_mkforms_tests_api_mainrenderer_testcase extends tx_rnbase_tests_BaseTestCase
{

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        tx_rnbase::load('tx_mklib_tests_Util');
        tx_mklib_tests_Util::prepareTSFE(array('force' => true, 'initFEuser' => true));

        $GLOBALS['TSFE']->fe_user->setKey('ses', 'mkforms', array());
        $GLOBALS['TSFE']->fe_user->storeSessionData();

        set_error_handler(array('tx_mkforms_tests_Util', 'errorHandler'), E_WARNING);
    }

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown()
    {
        // error handler zurücksetzen
        restore_error_handler();
    }

    /**
     */
    public function testRenderInsertsCorrectRequestTokenIntoHtmlAndSession()
    {
        $form = tx_mkforms_tests_Util::getForm();
        $renderer = tx_rnbase::makeInstance('formidable_mainrenderer');
        $renderer->_init($form, array(), array(), '');

        $rendered = $renderer->_render(array());

        self::assertContains(
            '<input type="hidden" name="radioTestForm[MKFORMS_REQUEST_TOKEN]" id="radioTestForm_MKFORMS_REQUEST_TOKEN" value="'.$form->generateRequestToken().'" />',
            $rendered['HIDDEN'],
            'Es ist nicht der richtige request token enthalten!'
        );


        //requestToken auch in der session?
        $sessionData = $GLOBALS['TSFE']->fe_user->getKey('ses', 'mkforms');
        self::assertCount(1, $sessionData['requestToken'], 'mehr request tokens in der session als erwartet!');
        self::assertEquals($sessionData['requestToken']['radioTestForm'], $form->generateRequestToken(), 'falscher request token in der session!');
    }

    /**
     */
    public function testRenderInsertsCorrectRequestTokenIntoHtmlAndSessionIfRequestTokensExist()
    {
        $GLOBALS['TSFE']->fe_user->setKey(
            'ses',
            'mkforms',
            array(
                'requestToken' => array(
                    'firstForm' => 'secret',
                    'secondForm' => 'anotherSecret',
                )
            )
        );
        $GLOBALS['TSFE']->fe_user->storeSessionData();


        $form = tx_mkforms_tests_Util::getForm();
        $renderer = tx_rnbase::makeInstance('formidable_mainrenderer');
        $renderer->_init($form, array(), array(), '');

        $rendered = $renderer->_render(array());

        self::assertContains(
            '<input type="hidden" name="radioTestForm[MKFORMS_REQUEST_TOKEN]" id="radioTestForm_MKFORMS_REQUEST_TOKEN" value="'.$form->generateRequestToken().'" />',
            $rendered['HIDDEN'],
            'Es ist nicht der richtige request token enthalten!'
        );


        //requestToken auch in der session?
        $sessionData = $GLOBALS['TSFE']->fe_user->getKey('ses', 'mkforms');
        self::assertCount(3, $sessionData['requestToken'], 'mehr request tokens in der session als erwartet!');
        self::assertEquals($sessionData['requestToken']['radioTestForm'], $form->generateRequestToken(), 'falscher request token in der session!');
        //alte request tokens richtig?
        self::assertEquals($sessionData['requestToken']['firstForm'], 'secret', 'falscher request token in der session!');
        self::assertEquals($sessionData['requestToken']['secondForm'], 'anotherSecret', 'falscher request token in der session!');
    }

    /**
     * @group unit
     */
    public function testRenderAppliesHtmlspcielcharsToActionUrl()
    {
        $form = $this->getMock('tx_mkforms_forms_Base', array('getFormAction'), array('generic'));
        $form
            ->expects(self::once())
            ->method('getFormAction')
            ->will(self::returnValue('/url.html?parameter=test&xss="/>ohoh'));

        $form = tx_mkforms_tests_Util::getForm(false, array(), null, $form);
        $renderer = $this->getMock('formidable_mainrenderer', array('setCreationTimestampToSession'));
        $renderer->_init($form, array(), array(), '');

        $renderedData = $renderer->_render(array());
        self::assertContains('action="/url.html?parameter=test&amp;xss=&quot;/&gt;ohoh"', $renderedData['FORMBEGIN']);
    }
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/tests/api/class.tx_mkforms_tests_api_mainvalidator_testcase.php']) {
    include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/tests/api/class.tx_mkforms_tests_api_mainvalidator_testcase.php']);
}
