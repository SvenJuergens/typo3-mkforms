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


	class formidable_maindataset extends formidable_mainobject {
		var $aData = FALSE;
		var $sKey = FALSE;
		var $oDataSource = FALSE;
		var $aChangedCells = array();		// stores the new value for cells of data that have changed
		var $aChangedCellsBefore = array(); // stores the previous value for cells of data that have changed
		var $bFloating = FALSE;

		function initFloating(&$oDataSource, $aData = array()) {
			$this->setFloating();
			$this->_initInternals($oDataSource, $aData);
		}
		
		function initAnchored(&$oDataSource, $aData, $sKey) {
			$this->setAnchored();
			$this->_initInternals($oDataSource, $aData);
			$this->sKey = $sKey;
		}

		function _initInternals(&$oDataSource, $aData) {
			$this->oForm =& $oDataSource->oForm;
			$this->aData = $aData;
			$this->oDataSource =& $oDataSource;
			$this->aChangedCells = array();
		}

		function getKey() {
			return $this->sKey;
		}

		function getData() {
			reset($this->aData);
			return $this->aData;
		}

		function setCellValue($sPath, $mValue) {
			$mPreviousValue = $this->oForm->setDeepData(
				$sPath,
				$this->aData,
				$mValue
			);

			if($mPreviousValue !== FALSE && $mPreviousValue !== $mValue) {
				$this->aChangedCells[$sPath] = $mValue;
				$this->aChangedCellsBefore[$sPath] = $mPreviousValue;
			}
		}
		
		function getCellValue($sPath) {
			$sPath = str_replace(".", "/", $sPath);
			if(($aRes = $this->oForm->navDeepData($sPath, $this->aData)) !== FALSE) {
				return $aRes;
			}
			
			return FALSE;
		}
		
		function needsToBeWritten() {
			return $this->somethingHasChanged();
		}
		
		function somethingHasChanged() {
			return count($this->aChangedCells) > 0;
		}
		
		function cellHasChanged($sPath) {
			return array_key_exists($sPath, $this->aChangedCells);
		}

		function setFloating() {
			$this->bFloating = TRUE;
		}

		function setAnchored() {
			$this->bFloating = FALSE;
		}

		function isFloating() {
			return $this->bFloating;
		}

		function isAnchored() {
			return !$this->isFloating();
		}
		
		function getSignature() {
			return base64_encode($this->oForm->_getSafeLock($this->sKey) . ":" . $this->sKey);
		}

		function baseCleanBeforeSession() {
			unset($this->oDataSource);
			$this->oDataSource = FALSE;
		}

		function getDataSet() {
			return array(
				"mode" => $this->isFloating() ? "create" : "update",
				"key" => $this->getKey(),
				"data" => $this->aData,
			);
		}
	}

?>