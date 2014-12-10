<?php

/**
 * Created by PhpStorm.
 * User: Dhebestreit
 * Date: 10.12.14
 * Time: 21:05
 */
class Dxt_ConfigManager_Block_Config_Data_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('grid_id');
        $this->setDefaultSort('config_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('dxt_configmanager/config')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('config_id',
            array(
                'header' => $this->__('Config Id'),
                'width' => '50px',
                'index' => 'config_id'
            )
        );

        $this->addColumn('scope',
            array(
                'header' => $this->__('Scope'),
                'width' => '50px',
                'index' => 'scope'
            )
        );

        $this->addColumn('scope_id',
            array(
                'header' => $this->__('Scope Id'),
                'width' => '50px',
                'index' => 'scope_id'
            )
        );

        $this->addColumn('website',
            array(
                'header'=> Mage::helper('catalog')->__('Websites'),
                'width' => '100px',
                'sortable'  => false,
                'index'     => 'scope_id',
                'type'      => 'options',
                'options'   => Mage::getSingleton('adminhtml/system_store')->getWebsiteOptionHash(true),
            ));

        $this->addColumn('path',
            array(
                'header' => $this->__('Path'),
                'width' => '50px',
                'index' => 'path'
            )
        );

        $this->addColumn('value',
            array(
                'header' => $this->__('Value'),
                'width' => '50px',
                'index' => 'value'
            )
        );

        $this->addExportType('*/*/exportCsv', $this->__('CSV'));

        $this->addExportType('*/*/exportExcel', $this->__('Excel XML'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $modelPk = Mage::getModel('dxt_configmanager/config')->getResource()->getIdFieldName();
        $this->setMassactionIdField($modelPk);
        $this->getMassactionBlock()->setFormFieldName('ids');
        // $this->getMassactionBlock()->setUseSelectAll(false);
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
        ));
        return $this;
    }
}
