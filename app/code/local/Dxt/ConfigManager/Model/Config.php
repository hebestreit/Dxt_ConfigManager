<?php

/**
 * Created by PhpStorm.
 * User: Dhebestreit
 * Date: 10.12.14
 * Time: 21:01
 */
class Dxt_ConfigManager_Model_Config extends Mage_Core_Model_Config_Data
{


    public function getFieldsConfig () {
        $sections = Mage::getSingleton('adminhtml/config')->getSections();

//      general/country/eu_countries = path
//        $groupConfig = $sections->descend($section . '/groups/' . $group);
        $groupConfig = $sections->descend('general/groups/country');
        $fieldConfig = $sections->descend('general/groups/country/fields/eu_countries');

        echo '<pre>';
//        var_dump($fieldConfig);
        echo '</pre>';


        $fieldConfigModel = new Varien_Object();
        foreach ($fieldConfig->children() as $field => $node) {
            $fieldConfigModel->setData((string) $field, (string) $node);
        }

        return $fieldConfigModel;
    }
}