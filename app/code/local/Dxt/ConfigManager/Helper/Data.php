<?php

/**
 * Created by PhpStorm.
 * User: Dhebestreit
 * Date: 10.12.14
 * Time: 20:57
 */
class Dxt_ConfigManager_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Explode config path to parts
     * @param $path
     * @return array
     */
    public function getConfigPathArray($path)
    {
        // path = general/country/eu_countries
        $explode = explode('/', $path);

        return array(
            'section' => $explode[0],
            'group' => $explode[1],
            'field' => $explode[2],
        );
    }

    public function getConfigPath(array $parts)
    {
        $path = $parts['section'] . '/' . $parts['group'] . '/' . $parts['field'];
        return $path;
    }

    public function getXmlConfigCollection()
    {
        $xmlConfig = Mage::getConfig()->getNode(null, 'default')[0];

        $collection = new Varien_Data_Collection();
        foreach ($xmlConfig as $sectionKey => $group) {
            $pathKey = $sectionKey;
            foreach ($group as $groupKey => $field) {
                $pathKey .= '/' . $groupKey;
                foreach ($field as $fieldKey => $value) {
                    $path = '';
                    $path = $pathKey . '/' . $fieldKey;

                    $item = new Varien_Object();
                    $item->setId($path);
                    $item->setPath($path);
                    $item->setValue((string) $value);

                    $collection->addItem($item);
                }
            }
        }

        return $collection;
    }

    public function getSystemXmlSections () {
        $current = 'design';
        $configFields = Mage::getSingleton('adminhtml/config');
        $sections     = $configFields->getSections($current);
        $section = $sections->$current;
        $hasChildren  = $configFields->hasChildren($section, null, null);
    }
}