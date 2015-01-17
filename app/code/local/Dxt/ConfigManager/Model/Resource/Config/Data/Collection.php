<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Core
 * @copyright  Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Config data collection
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Dxt_ConfigManager_Model_Resource_Config_Data_Collection extends Varien_Data_Collection_Filesystem
{

    /**
     * Merge config cache with config data of database
     * @param bool $printQuery
     * @param bool $logQuery
     * @return $this|Varien_Data_Collection_Filesystem
     */
    public function loadData($printQuery = false, $logQuery = false) {
        if ($this->isLoaded()) {
            return $this;
        }

        // get data collection from database
        $dbDataCollection = Mage::getModel('core/config_data')->getCollection();

        /** @todo implement config data of config cache */
//        $configDataCollection = Mage::helper('dxt_configmanager')->getXmlConfigCollection();
        $configDataCollection = new Varien_Data_Collection();
        $tmpItem = new Varien_Object();
        $dataArray = array(
            'config_id' => null,
            'value' => '0',
            'path' => 'catalog/frontend/grid_per_page_values',
        );
        $tmpItem->addData($dataArray);
        $configDataCollection->addItem($tmpItem);
        /** @todo implement config data of config cache */

        $tmpCollection = new Varien_Data_Collection();

        // add each item of database config to temp collection
        foreach ($dbDataCollection as $item) {
            $item->setType('db');
            $tmpCollection->addItem($item);
        }

        // add each item of config cache to temp collection
        foreach ($configDataCollection as $item) {
            // if item already exists continue
            if($tmpCollection->getItemById($item->getPath())) {
                continue;
            }
            $item->setType('xml');
            $tmpCollection->addItem($item);
        }


        // calculate totals
        $this->_totalRecords = count($tmpCollection);
        $this->_setIsLoaded();

        // paginate and add items
        $from = ($this->getCurPage() - 1) * $this->getPageSize();
        $to = $from + $this->getPageSize() - 1;
        $isPaginated = $this->getPageSize() > 0;

        $i = 0;
        foreach ($tmpCollection as $row) {
            $i++;
            if ($isPaginated && ($i < $from || $i > $to)) {
                continue;
            }
            $item = new $this->_itemObjectClass();
            $this->addItem($row);
            if (!$item->hasId()) {
                $item->setId($i);
            }
        }

        return $this;

    }


    public function __construct()
    {
        // we need to set this
        $this->addTargetDir('media');
    }


}
