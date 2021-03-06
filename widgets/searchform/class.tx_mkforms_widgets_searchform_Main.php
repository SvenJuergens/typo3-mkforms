<?php
/**
 * Plugin 'rdt_searchform' for the 'ameos_formidable' extension.
 *
 * @author  Jerome Schneider <typo3dev@ameos.com>
 */


class tx_mkforms_widgets_searchform_Main extends formidable_mainrenderlet
{
    public $oDataSource = false;
    public $aCriterias = false;
    public $aFilters = false;
    public $aDescendants = false;

    public function _init(&$oForm, $aElement, $aObjectType, $sXPath, $sNamePrefix = false)
    {
        parent::_init($oForm, $aElement, $aObjectType, $sXPath);
        $this->_initDescendants();    // early init (meaning before removing unprocessed rdts)
    }

    public function _render()
    {
        $this->_initData();

        $aChildBags = $this->renderChildsBag();
        $sCompiledChilds = $this->renderChildsCompiled($aChildBags);

        if ($this->isRemoteReceiver() && !$this->mayDisplayRemoteReceiver()) {
            return array(
                '__compiled' => '',
            );
        }

        return array(
            '__compiled' => $this->_displayLabel($sLabel) . $sCompiledChilds,
            'childs' => $aChildBags
        );
    }

    public function getDescendants()
    {
        $aDescendants = array();
        $sMyName = $this->getAbsName();

        $aRdts = array_keys($this->oForm->aORenderlets);
        reset($aRdts);
        while (list(, $sName) = each($aRdts)) {
            if ($this->oForm->aORenderlets[$sName]->isDescendantOf($sMyName)) {
                $aDescendants[] = $sName;
            }
        }

        return $aDescendants;
    }

    public function _initDescendants($bForce = false)
    {
        if ($bForce === true || $this->aDescendants === false) {
            $this->aDescendants = $this->getDescendants();
        }
    }

    public function _initData()
    {
        $this->_initDescendants(true);    // done in _init(), re-done here to filter out unprocessed rdts
        $this->_initCriterias();    // if submitted, take from post ; if not, take from session
                                    // and inject values into renderlets
        $this->_initFilters();
        $this->_initDataSource();
    }

    public function mayHaveChilds()
    {
        return true;
    }

    public function isRemoteSender()
    {
        return ($this->_navConf('/remote/mode') === 'sender');
    }

    public function isRemoteReceiver()
    {
        return ($this->_navConf('/remote/mode') === 'receiver');
    }

    public function _initDataSource()
    {
        if ($this->isRemoteSender()) {
            return;
        }

        if ($this->oDataSource === false) {
            if (($sDsToUse = $this->_navConf('/datasource/use')) === false) {
                $this->oForm->mayday('RENDERLET SEARCHFORM - requires /datasource/use to be properly set. Check your XML conf.');
            } elseif (!array_key_exists($sDsToUse, $this->oForm->aODataSources)) {
                $this->oForm->mayday("RENDERLET SEARCHFORM - refers to undefined datasource '" . $sDsToUse . "'. Check your XML conf.");
            }

            $this->oDataSource =& $this->oForm->aODataSources[$sDsToUse];
        }
    }

    public function clearFilters()
    {
        reset($this->aDescendants);
        while (list(, $sName) = each($this->aDescendants)) {
            $this->oForm->aORenderlets[$sName]->setValue('');
        }

        $this->aCriterias = false;
        tx_mkforms_session_Factory::getSessionManager()->initialize();
        $aAppData =& $GLOBALS['_SESSION']['ameos_formidable']['applicationdata'];
        $aAppData['rdt_lister'][$this->oForm->formid][$this->getAbsName()]['criterias'] = array();

        if ($this->isRemoteReceiver()) {
            $aAppData['rdt_lister'][$this->getRemoteSenderFormId()][$this->getRemoteSenderAbsName()]['criterias'] = array();
        }
    }

    public function getCriterias()
    {
        return $this->aCriterias;
    }


    public function getRemoteSenderFormId()
    {
        if ($this->isRemoteReceiver()) {
            if (($sSenderFormId = $this->_navConf('/remote/senderformid')) !== false) {
                return $sSenderFormId;
            }
        }

        return false;
    }

    public function getRemoteSenderAbsName()
    {
        if ($this->isRemoteReceiver()) {
            if (($sSenderAbsName = $this->_navConf('/remote/senderabsname')) !== false) {
                return $sSenderAbsName;
            }
        }

        return false;
    }

    public function _initCriterias()
    {
        if ($this->aCriterias === false) {
            $bUpdate = false;

            if ($this->isRemoteReceiver()) {
                if (($sFormId = $this->getRemoteSenderFormId()) === false) {
                    $this->oForm->mayday('RENDERLET SEARCHFORM - requires /remote/senderFormId to be properly set. Check your XML conf.');
                }

                if (($sSearchAbsName = $this->getRemoteSenderAbsName()) === false) {
                    $this->oForm->mayday('RENDERLET SEARCHFORM - requires /remote/senderAbsName to be properly set. Check your XML conf.');
                }
            } else {
                $sFormId = $this->oForm->formid;
                $sSearchAbsName = $this->getAbsName();
            }

            $this->aCriterias = array();

            tx_mkforms_session_Factory::getSessionManager()->initialize();
            $aAppData =& $GLOBALS['_SESSION']['ameos_formidable']['applicationdata'];

            if (!array_key_exists('rdt_lister', $aAppData)) {
                $aAppData['rdt_lister'] = array();
            }

            if (!array_key_exists($sFormId, $aAppData['rdt_lister'])) {
                $aAppData['rdt_lister'][$sFormId] = array();
            }

            if (!array_key_exists($sSearchAbsName, $aAppData['rdt_lister'][$sFormId])) {
                $aAppData['rdt_lister'][$sFormId][$sSearchAbsName] = array();
            }

            if (!array_key_exists('criterias', $aAppData['rdt_lister'][$sFormId][$sSearchAbsName])) {
                $aAppData['rdt_lister'][$sFormId][$sSearchAbsName]['criterias'] = array();
            }

            if ($this->shouldUpdateCriteriasClassical()) {
                $bUpdate = true;

                if ($this->isRemoteReceiver()) {
                    // set in session
                    reset($this->aDescendants);
                    while (list(, $sAbsName) = each($this->aDescendants)) {
                        $sRelName = $this->oForm->aORenderlets[$sAbsName]->getNameRelativeTo($this);
                        $sRemoteAbsName = $sSearchAbsName . '.' . $sRelName;
                        $this->aCriterias[$sRemoteAbsName] = $this->oForm->aORenderlets[$sAbsName]->getValue();
                    }
                } else {
                    // set in session
                    reset($this->aDescendants);
                    while (list(, $sAbsName) = each($this->aDescendants)) {
                        if (!$this->oForm->aORenderlets[$sAbsName]->hasChilds()) {
                            $this->aCriterias[$sAbsName] = $this->oForm->aORenderlets[$sAbsName]->getValue();
                        }
                    }
                }
            } elseif ($this->shouldUpdateCriteriasRemoteReceiver()) {
                $bUpdate = true;
                if ($this->isRemoteReceiver()) {
                    // set in session

                    $aRawPost = $this->oForm->_getRawPost($sFormId);

                    reset($this->aDescendants);
                    while (list(, $sAbsName) = each($this->aDescendants)) {
                        $sRelName = $this->oForm->aORenderlets[$sAbsName]->getNameRelativeTo($this);
                        $sRemoteAbsName = $sSearchAbsName . '.' . $sRelName;
                        $sRemoteAbsPath = str_replace('.', '/', $sRemoteAbsName);

                        $mValue = $this->oForm->navDeepData($sRemoteAbsPath, $aRawPost);
                        $this->aCriterias[$sRemoteAbsName] = $mValue;
                        $this->oForm->aORenderlets[$sAbsName]->setValue($mValue);    // setting value in receiver
                    }
                }
            }

            if ($bUpdate === true) {
                if ($this->_getParamsFromGET()) {
                    $aGet = (Tx_Rnbase_Utility_T3General::_GET($sFormId)) ? Tx_Rnbase_Utility_T3General::_GET($sFormId) : array();

                    reset($aGet);
                    while (list($sAbsName, ) = each($aGet)) {
                        if (array_key_exists($sAbsName, $this->oForm->aORenderlets)) {
                            $this->aCriterias[$sAbsName] = $aGet[$sAbsName];

                            $this->oForm->aORenderlets[$sAbsName]->setValue(
                                $this->aCriterias[$sAbsName]
                            );

                            $aTemp = array(
                                $sFormId => array(
                                    $sAbsName => 1,
                                ),
                            );

                            $this->oForm->setParamsToRemove($aTemp);
                        }
                    }
                }

                $aAppData['rdt_lister'][$sFormId][$sSearchAbsName]['criterias'] = $this->aCriterias;
            } else {
                // take from session
                $this->aCriterias = $aAppData['rdt_lister'][$sFormId][$sSearchAbsName]['criterias'];

                if ($this->isRemoteReceiver()) {
                    if (($sFormId = $this->getRemoteSenderFormId()) === false) {
                        $this->oForm->mayday('RENDERLET SEARCHFORM - requires /remote/senderFormId to be properly set. Check your XML conf.');
                    }

                    if (($sSearchAbsName = $this->getRemoteSenderAbsName()) === false) {
                        $this->oForm->mayday('RENDERLET SEARCHFORM - requires /remote/senderAbsName to be properly set. Check your XML conf.');
                    }

                    reset($this->aCriterias);
                    while (list($sAbsName, ) = each($this->aCriterias)) {
                        $sRelName = $this->oForm->relativizeName(
                            $sAbsName,
                            $sSearchAbsName
                        );

                        $sLocalAbsName = $this->getAbsName() . '.' . $sRelName;
                        if (array_key_exists($sLocalAbsName, $this->oForm->aORenderlets)) {
                            $this->oForm->aORenderlets[$sLocalAbsName]->setValue(
                                $this->aCriterias[$sAbsName]
                            );
                        }
                    }
                } else {
                    reset($this->aCriterias);
                    while (list($sAbsName, ) = each($this->aCriterias)) {
                        if (array_key_exists($sAbsName, $this->oForm->aORenderlets)) {
                            $this->oForm->aORenderlets[$sAbsName]->setValue(
                                $this->aCriterias[$sAbsName]
                            );
                        }
                    }
                }
            }
        }
    }

    public function shouldUpdateCriteriasRemoteReceiver()
    {
        if ($this->isRemoteReceiver()) {
            if (($sFormId = $this->getRemoteSenderFormId()) === false) {
                $this->oForm->mayday('RENDERLET SEARCHFORM - requires /remote/senderFormId to be properly set. Check your XML conf.');
            }

            if (($sSearchAbsName = $this->getRemoteSenderAbsName()) === false) {
                $this->oForm->mayday('RENDERLET SEARCHFORM - requires /remote/senderAbsName to be properly set. Check your XML conf.');
            }

            if ($this->oForm->oDataHandler->_isSearchSubmitted($sFormId) || $this->oForm->oDataHandler->_isFullySubmitted($sFormId)) {    // full submit to allow no-js browser to search
                reset($this->aDescendants);
                while (list(, $sAbsName) = each($this->aDescendants)) {
                    $sRelName = $this->oForm->aORenderlets[$sAbsName]->getNameRelativeTo($this);
                    $sRemoteAbsName = $sSearchAbsName . '.' . $sRelName;

                    if ($this->oForm->aORenderlets[$sAbsName]->hasSubmitted($sFormId, $sRemoteAbsName)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function shouldUpdateCriteriasClassical()
    {
        if ($this->oForm->oDataHandler->_isSubmitted() === true) {
            reset($this->aDescendants);
            while (list(, $sAbsName) = each($this->aDescendants)) {
                if (array_key_exists($sAbsName, $this->oForm->aORenderlets) &&
                    $this->oForm->aORenderlets[$sAbsName]->hasSubmitted() &&
                    $this->oForm->oDataHandler->_isSearchSubmitted()) {    // the mode is not determined by the renderlet anymore, but rather by the datahandler (one common submit per page, anyway)

                    return true;
                }
            }
        } else {
            if ($this->_getParamsFromGET()) {
                $aGet = (Tx_Rnbase_Utility_T3General::_GET($this->oForm->formid)) ? Tx_Rnbase_Utility_T3General::_GET($this->oForm->formid) : array();
                $aIntersect = array_intersect(array_keys($aGet), array_keys($this->oForm->aORenderlets));

                return count($aIntersect) > 0;    // are there get params in url matching at least one criteria in the searchform ?
            }
        }

        return false;
    }

    public function shouldUpdateCriterias()
    {
        if (!$this->isRemoteReceiver()) {
            return $this->shouldUpdateCriteriasClassical();
        }

        return false;
    }

    public function mayDisplayRemoteReceiver()
    {
        return $this->isRemoteReceiver() && !$this->_defaultTrue('/remote/invisible');
    }

    public function processBeforeSearch($aCriterias)
    {
        if (($aBeforeSearch = $this->_navConf('/beforesearch')) !== false && $this->oForm->isRunneable($aBeforeSearch)) {
            $aCriterias = $this->getForm()->getRunnable()->callRunnableWidget($this, $aBeforeSearch, $aCriterias);
        }

        if (!is_array($aCriterias)) {
            $aCriterias = array();
        }

        return $aCriterias;
    }

    public function processAfterSearch($aResults)
    {
        if (($aAfterSearch = $this->_navConf('/aftersearch')) !== false && $this->oForm->isRunneable($aAfterSearch)) {
            $aResults = $this->getForm()->getRunnable()->callRunnableWidget($this, $aAfterSearch, $aResults);
        }

        if (!is_array($aResults)) {
            $aResults = array();
        }

        return $aResults;
    }

    public function _initFilters()
    {
        if ($this->aFilters === false) {
            $this->aFilters = array();

            $aCriterias = $this->processBeforeSearch($this->aCriterias);
            reset($aCriterias);

            if ($this->isRemoteReceiver()) {
                if (($sFormId = $this->getRemoteSenderFormId()) === false) {
                    $this->oForm->mayday('RENDERLET SEARCHFORM - requires /remote/senderFormId to be properly set. Check your XML conf.');
                }

                if (($sSearchAbsName = $this->getRemoteSenderAbsName()) === false) {
                    $this->oForm->mayday('RENDERLET SEARCHFORM - requires /remote/senderAbsName to be properly set. Check your XML conf.');
                }

                while (list($sRdtName, ) = each($aCriterias)) {
                    $sRelName = $this->oForm->relativizeName(
                        $sRdtName,
                        $sSearchAbsName
                    );


                    $sLocalAbsName = $this->getAbsName() . '.' . $sRelName;

                    if (array_key_exists($sLocalAbsName, $this->oForm->aORenderlets)) {
                        $oRdt =& $this->oForm->aORenderlets[$sLocalAbsName];

                        if ($oRdt->_searchable()) {
                            $sValue = $oRdt->_flatten($aCriterias[$sRdtName]);

                            if (!$oRdt->_emptyFormValue($sValue)) {
                                $this->aFilters[] = $oRdt->_sqlSearchClause($sValue);
                            }
                        }
                    }
                }
            } else {
                while (list($sRdtName, ) = each($aCriterias)) {
                    if (array_key_exists($sRdtName, $this->oForm->aORenderlets)) {
                        $oRdt =& $this->oForm->aORenderlets[$sRdtName];

                        if ($oRdt->_searchable()) {
                            $sValue = $oRdt->_flatten($aCriterias[$sRdtName]);

                            if (!$oRdt->_emptyFormValue($sValue)) {
                                $this->aFilters[] = $oRdt->_sqlSearchClause($sValue);
                            }
                        }
                    }
                }
            }

            reset($this->aFilters);
        }
    }

    public function &_getFilters()
    {
        $this->_initFilters();
        reset($this->aFilters);

        return $this->aFilters;
    }

    public function &fetchData($aConfig = array())
    {
        return $this->_fetchData($aConfig);
    }

    public function &_fetchData($aConfig = array())
    {
        return $this->processAfterSearch(
            $this->oDataSource->_fetchData(
                $aConfig,
                $this->_getFilters()
            )
        );
    }

    public function _renderOnly($bForAjax = false)
    {
        return $this->_defaultTrue('/renderonly');
    }

    public function _getParamsFromGET()
    {
        return $this->_defaultFalse('/paramsfromget');
    }

    public function _searchable()
    {
        return false;
    }
}


if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/ameos_formidable/api/base/rdt_searchform/api/class.tx_rdtsearchform.php']) {
    include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/ameos_formidable/api/base/rdt_searchform/api/class.tx_rdtsearchform.php']);
}
