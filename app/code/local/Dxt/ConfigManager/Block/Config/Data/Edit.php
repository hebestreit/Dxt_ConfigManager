<?php

/**
 * Created by PhpStorm.
 * User: Dhebestreit
 * Date: 10.12.14
 * Time: 21:05
 */
class Dxt_ConfigManager_Block_Config_Data_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        // $this->_objectId = 'id';
        parent::__construct();
        $this->_blockGroup = 'dxt_configmanager';
        $this->_controller = 'config_data';
        $this->_mode = 'edit';
        $modelTitle = $this->_getModelTitle();
        /** @todo add duplicate button */
        $this->_updateButton('save', 'label', $this->_getHelper()->__("Save $modelTitle"));
        $this->_addButton('saveandcontinue', array(
            'label' => $this->_getHelper()->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Return helper
     * @return Dxt_ConfigManager_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('dxt_configmanager');
    }

    /**
     * Return model object
     * @return Dxt_ConfigManager_Model_Config_Data
     */
    protected function _getModel()
    {
        return Mage::registry('current_model');
    }

    /**
     * Return model title
     * @return string
     */
    protected function _getModelTitle()
    {
        return 'Configuration';
    }

    /**
     * Return header text
     * @return string
     */
    public function getHeaderText()
    {
        $configData = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        if ($configData && $configData->getId()) {
            return $this->_getHelper()->__("Edit $modelTitle (ID: {$configData->getId()})");
        } else {
            return $this->_getHelper()->__("New $modelTitle");
        }
    }


    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/index');
    }

    /**
     * Return delete url
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', array($this->_objectId => $this->getRequest()->getParam($this->_objectId)));
    }

    /**
     * Get form save URL
     *
     * @deprecated
     * @see getFormActionUrl()
     * @return string
     */
    public function getSaveUrl()
    {
        $this->setData('form_action_url', 'save');
        return $this->getFormActionUrl();
    }


}
