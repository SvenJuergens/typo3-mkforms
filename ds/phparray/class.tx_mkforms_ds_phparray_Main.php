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
 * Plugin 'ds_phparray' for the 'ameos_formidable' extension.
 *
 * @author	Jerome Schneider <typo3dev@ameos.com>
 */

class tx_mkforms_ds_phparray_Main extends formidable_maindatasource {

	var $aSource = FALSE;
	var $aPosByUid = FALSE;
	var $aConfig = array();
	var $aFilters = array();
	var $iTotalRows = 0;

	function &_fetchData($aConfig = array(), $aFilters = array()) {

		$this->aConfig =& $aConfig;
		$this->aFilters =& $aFilters;

		$this->initBinding($aConfig, $aFilters);

		return array(
			'numrows' => $this->iTotalRows,
			'results' => &$this->aSource,
		);
	}

	private function initBinding($aConfig, $aFilters) {
		if($this->getForm()->getRunnable()->isRunnable(($aBindsTo = $this->_navConf('/bindsto')))) {
			$params = array('config' => $aConfig,  'filters' => $aFilters);
			$this->aSource =& $this->getForm()->getRunnable()->callRunnable($aBindsTo, $params, $this);

			if(!is_array($this->aSource)) {
				$this->aSource = array();
				$this->iTotalRows = 0;
			} else {
				$this->iTotalRows = count($this->aSource);
			}
		}

		$this->_sortSource();
		$this->_limitSource();
	}

	function _sortSource() {
		if(trim($this->aConfig['sortcolumn']) !== '') {
			
			$aSorted = array();
			
			reset($this->aSource);
			$named_hash = array();

			foreach($this->aSource as $key => $fields) {
				$named_hash[$key] = $fields[$this->aConfig['sortcolumn']];
			}

			if($this->aConfig['sortdirection'] === 'desc') {
				arsort($named_hash, $flags=0);
			} else {
				asort($named_hash, $flags=0);
			}
			
			$k = 1;
			$this->aPosByUid = array();
			$sorted_records = array();
			
			foreach($named_hash as $key=>$val) {
				$aSorted[$key] = $this->aSource[$key];
				$this->aPosByUid[$aSorted[$key]['uid']] = $k;
				$k++;
			}
			
			reset($this->aPosByUid);
			
			return $this->aSource =& $aSorted;
		} else {
			
			$k = 1;
			$this->aPosByUid = array();
			$aKeys = array_keys($this->aSource);
			
			reset($aKeys);
			while(list(, $sKey) = each($aKeys)) {
				$this->aPosByUid[$this->aSource[$sKey]['uid']] = $k;
				$k++;
			}
			
			reset($this->aPosByUid);
		}
	}

	function _limitSource() {

		$aLimit = $this->_getRecordWindow(
			$this->aConfig['page'],
			$this->aConfig['perpage']
		);

		$this->aSource = array_slice(
			$this->aSource,
			$aLimit['offset'],
			$aLimit['nbdisplayed']
		);
	}
	
	function getRowNumberForUid($iUid) {
		if(array_key_exists($iUid, $this->aPosByUid)) {
			return $this->aPosByUid[$iUid];
		}
		
		return FALSE;
	}
}


	if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/ds/phparray/class.tx_mkforms_ds_phparray_Main.php'])	{
		include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mkforms/ds/phparray/class.tx_mkforms_ds_phparray_Main.php']);
	}
?>
