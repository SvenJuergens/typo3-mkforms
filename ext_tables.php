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


if (!defined ('TYPO3_MODE'))     die ('Access denied.');

////////////////////////////////
// Plugin anmelden
////////////////////////////////
// Einige Felder ausblenden
$TCA['tt_content']['types']['list']['subtypes_excludelist']['tx_mkforms']='layout,select_key,pages';

// Das tt_content-Feld pi_flexform einblenden
$TCA['tt_content']['types']['list']['subtypes_addlist']['tx_mkforms'] = 'pi_flexform';

t3lib_extMgm::addPiFlexFormValue('tx_mkforms','FILE:EXT:'.$_EXTKEY.'/flexform_main.xml');

//t3lib_extMgm::addPlugin(Array('LLL:EXT:'.$_EXTKEY.'/locallang_db.php:plugin.mkforms.label','tx_mkforms'));
t3lib_extMgm::addPlugin(
		array(
			'LLL:EXT:'.$_EXTKEY.'/locallang_db.php:plugin.mkforms.label',
			'tx_mkforms',
			t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif',
		)
	);

t3lib_extMgm::addStaticFile($_EXTKEY,'static/ts/', 'MK Forms - Basics');
t3lib_extMgm::addStaticFile($_EXTKEY,'static/prototype/', 'MK Forms Prototype-JS');
t3lib_extMgm::addStaticFile($_EXTKEY,'static/jquery/', 'MK Forms JQuery-JS');

//	t3lib_div::loadTCA('tt_content');
//	$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';
//	t3lib_extMgm::addPlugin(Array('FORMIDABLE cObj (cached)', $_EXTKEY.'_pi1'),'list_type');
//
//	
//	$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';
//	t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:' . $_EXTKEY . '/pi1/flexform.xml');
//
//	if (TYPO3_MODE=='BE') {
//		$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['ameos_formidable_pi1_wizicon'] =
//			t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_ameosformidable_pi1_wizicon.php';
//	}
//
//
//
//	$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';
//	t3lib_extMgm::addPlugin(Array('FORMIDABLE_INT cObj (not cached)', $_EXTKEY.'_pi2'),'list_type');
//
//	
//	$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi2']='pi_flexform';
//	t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi2', 'FILE:EXT:' . $_EXTKEY . '/pi2/flexform.xml');

//	if (TYPO3_MODE=='BE') {
//		$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['ameos_formidable_pi2_wizicon'] =
//			t3lib_extMgm::extPath($_EXTKEY).'pi2/class.tx_ameosformidable_pi2_wizicon.php';
//	}

?>
