<?php

/**
 * Created by PhpStorm.
 * User: Dhebestreit
 * Date: 10.12.14
 * Time: 21:05
 */
class Dxt_ConfigManager_Block_Config_Data extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'dxt_configmanager';
        $this->_controller = 'config_data';
        // $this->_headerText      = $this->__('Grid Header Text');
        // $this->_addButtonLabel  = $this->__('Add Button Label');
        parent::__construct();
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

}

