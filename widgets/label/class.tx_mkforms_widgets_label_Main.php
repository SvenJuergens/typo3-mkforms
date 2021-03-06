<?php
/**
 * Plugin 'rdt_lbl' for the 'ameos_formidable' extension.
 *
 * @author  Jerome Schneider <typo3dev@ameos.com>
 */


class tx_mkforms_widgets_label_Main extends formidable_mainrenderlet
{
    public function _renderReadOnly()
    {
        $aItems = $this->_getItems();
        $value = $this->oForm->oDataHandler->getThisFormData($this->_getName());

        $sCaption = $value;

        if (count($aItems) > 0) {
            reset($aItems);
            while (list($itemindex, $aItem) = each($aItems)) {
                if ($aItem['value'] == $value) {
                    $sCaption = $aItem['caption'];
                }
            }
        }

        $sCaption = htmlspecialchars($this->oForm->getConfigXML()->getLLLabel($sCaption));

        return $sCaption;
    }

    public function _renderOnly($bForAjax = false)
    {
        return true;
    }

    public function _readOnly()
    {
        return true;
    }
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ameos_formidable/api/base/rdt_lbl/api/class.tx_rdtlbl.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ameos_formidable/api/base/rdt_lbl/api/class.tx_rdtlbl.php']);
}
