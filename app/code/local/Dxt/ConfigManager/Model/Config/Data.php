<?php

/**
 * Created by PhpStorm.
 * User: Dhebestreit
 * Date: 10.12.14
 * Time: 21:01
 */
class Dxt_ConfigManager_Model_Config_Data extends Mage_Core_Model_Config_Data
{

    protected function _construct() {
        $this->_init('dxt_configmanager/config_data');
    }

    /**
     * Return additional information of config path
     * @todo some checks if node exists
     * @return Varien_Object
     */
    public function getFieldsConfig () {
        $sections = Mage::getSingleton('adminhtml/config')->getSections();

        // explode config path to parts
        $path = Mage::helper('dxt_configmanager')->getConfigPathArray($this->getPath());

        // get xml node with additional information
        // use Mage::getSingleton('adminhtml/config')->getSystemConfigNodeLabel() instead
        $fieldConfig = $sections->descend($path['section'] . '/groups/' . $path['group'] . '/fields/' . $path['field']);

        // convert xml data to Varien_Object
        $fieldConfigModel = new Varien_Object();
        foreach ($fieldConfig->children() as $field => $node) {
            $fieldConfigModel->setData((string) $field, (string) $node);
        }

        return $fieldConfigModel;
    }

    /**
     * Load object data
     *
     * @param   integer $id
     * @param null $field
     * @return  Mage_Core_Model_Abstract
     */
    public function load($id, $field=null)
    {
        // change resource name to get data from database (Mage_Core_Model_Config_Data)
        $this->_resourceName = 'core/config_data';

        /** @todo load data from config cache if not in database */
        parent::load($id, $field);
    }

    /**
     * Save object data
     * @return Mage_Core_Model_Abstract|void
     */
    public function save() {
        // change resource name to save item to database (Mage_Core_Model_Config_Data)
        $this->_resourceName = 'core/config_data';
        parent::save();
    }

    /**
     * @return Mage_Core_Model_Abstract|void
     */
    public function delete() {
        // change resource name to delete item from database (Mage_Core_Model_Config_Data)
        $this->_resourceName = 'core/config_data';
        parent::delete();
    }
}