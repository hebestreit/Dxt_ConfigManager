<?php

/**
 * Created by PhpStorm.
 * User: Dhebestreit
 * Date: 10.12.14
 * Time: 21:05
 */
class Dxt_ConfigManager_Block_Config_Data_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _getModel()
    {
        return Mage::registry('current_model');
    }

    protected function _getHelper()
    {
        return Mage::helper('dxt_configmanager');
    }


    protected function _prepareForm()
    {
        /** @var Dxt_ConfigManager_Model_Config_Data $model */
        $model = $this->_getModel();
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save'),
            'method' => 'post'
        ));

        // add field config label of system.xml as title
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => $this->_getHelper()->__($model->getFieldsConfig()->getLabel()),
            'class' => 'fieldset-wide',
        ));

        if ($model && $model->getId()) {
            $modelPk = $model->getResource()->getIdFieldName();
            $fieldset->addField($modelPk, 'hidden', array(
                'name' => $modelPk,
            ));
        }

//        $fieldset->addField('name', 'text' /* select | multiselect | hidden | password | ...  */, array(
//            'name'      => 'name',
//            'label'     => $this->_getHelper()->__('Label here'),
//            'title'     => $this->_getHelper()->__('Tooltip text here'),
//            'required'  => true,
//            'options'   => array( OPTION_VALUE => OPTION_TEXT, ),                 // used when type = "select"
//            'values'    => array(array('label' => LABEL, 'value' => VALUE), ),    // used when type = "multiselect"
//            'style'     => 'css rules',
//            'class'     => 'css classes',
//        ));
//          // custom renderer (optional)
//          $renderer = $this->getLayout()->createBlock('Block implementing Varien_Data_Form_Element_Renderer_Interface');
//          $field->setRenderer($renderer);

//      // New Form type element (extends Varien_Data_Form_Element_Abstract)
//        $fieldset->addType('custom_element','MyCompany_MyModule_Block_Form_Element_Custom');  // you can use "custom_element" as the type now in ::addField([name], [HERE], ...)


//        $fieldset->addType('custom_element','Dxt_ConfigManager_Block_Form_Element_Custom');


        if($model->getFieldsConfig()->getComment()) {
            /** @todo display comment as column */
            $commentHtml = $this->_getHelper()->__('Comment: ') . $model->getFieldsConfig()->getComment();
            $fieldset->addField('comment', 'hidden', array(
                'name' => 'comment',
                'label' => $this->_getHelper()->__('Config Path'),
                'title' => $this->_getHelper()->__('Config Path'),
                'after_element_html' =>  $commentHtml,
            ));
        }


        $fieldset->addField('scope', 'select', array(
            'name' => 'scope',
            'label' => $this->_getHelper()->__('Scope'),
            'title' => $this->_getHelper()->__('Scope'),
            'required' => true,
            'options' => array('default' => 'Default', 'stores' => 'Stores'),
        ));

        /** @todo implement dynamic store select like dataflow profile with optgroup */
        $scopeIdField = $fieldset->addField('scope_id', 'select', array(
            'name' => 'scope_id',
            'label' => $this->_getHelper()->__('Scope Id'),
            'title' => $this->_getHelper()->__('Scope Id'),
            'required' => true,
            'options'   => Mage::getSingleton('adminhtml/system_store')->getWebsiteOptionHash(true),
        ));

//        $scopeIdField->setRenderer($this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element'));

        $fieldset->addField('path', 'text', array(
            'name' => 'path',
            'label' => $this->_getHelper()->__('Config Path'),
            'title' => $this->_getHelper()->__('Config Path'),
            'required' => true,
        ));

        $fieldset->addField('value', 'text', array(
            'name' => 'value',
            'label' => $this->_getHelper()->__('Config Value'),
            'title' => $this->_getHelper()->__('Config Value'),
            'required' => true,
        ));

        if ($model) {
            $form->setValues($model->getData());
        }
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
