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

    /**
     * Prepare collection
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('dxt_configmanager/config_data')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid colums
     * @todo implement filtering and sorting
     * @return $this
     */
    protected function _prepareColumns()
    {

        $this->addColumn('config_id',
            array(
                'header' => $this->__('Config Id'),
                'width' => '50px',
                'index' => 'config_id',
                'sortable'  => false,
                'filter'  => false,
            )
        );

        $this->addColumn('type',
            array(
                'header' => $this->__('Type'),
                'width' => '50px',
                'index' => 'type',
                'type'      => 'options',
                'options'   => array(
                    'db' => 'Database',
                    'xml' => 'XML-File',
                ),
                'sortable'  => false,
                'filter'  => false,
            )
        );

        $this->addColumn('scope',
            array(
                'header' => $this->__('Scope'),
                'width' => '50px',
                'index' => 'scope',
                'sortable'  => false,
                'filter' => false,
            )
        );

        $this->addColumn('scope_id',
            array(
                'header' => $this->__('Scope Id'),
                'width' => '50px',
                'index' => 'scope_id',
                'sortable'  => false,
                'filter' => false,
            )
        );

        $this->addColumn('website',
            array(
                'header'=> Mage::helper('catalog')->__('Websites'),
                'width' => '100px',
                'index'     => 'scope_id',
                'type'      => 'options',
                'options'   => Mage::getSingleton('adminhtml/system_store')->getWebsiteOptionHash(true),
                'sortable'  => false,
                'filter'  => false,
            ));

        $this->addColumn('path',
            array(
                'header' => $this->__('Path'),
                'width' => '50px',
                'index' => 'path',
                'sortable'  => false,
                'filter'  => false,
            )
        );

        $this->addColumn('value',
            array(
                'header' => $this->__('Value'),
                'width' => '50px',
                'index' => 'value',
                'sortable'  => false,
                'filter'  => false,
            )
        );

        /** @todo implement export */
        // $this->addExportType('*/*/exportCsv', $this->__('CSV'));
        // $this->addExportType('*/*/exportExcel', $this->__('Excel XML'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        // explode config path to his parts
        $parameters = Mage::helper('dxt_configmanager')->getConfigPathArray($row->getPath());
        if(is_int($row->getId())) {
            $parameters['id'] = $row->getId();
        }


        return $this->getUrl('*/*/edit', $parameters);
    }

    protected function _prepareMassaction()
    {
        /** @todo implement later */
        //        $modelPk = Mage::getModel('dxt_configmanager/config_data')->getResource()->getIdFieldName();
        //        $this->setMassactionIdField($modelPk);
        //        $this->getMassactionBlock()->setFormFieldName('ids');
        //        // $this->getMassactionBlock()->setUseSelectAll(false);
        //        $this->getMassactionBlock()->addItem('delete', array(
        //            'label' => $this->__('Delete'),
        //            'url' => $this->getUrl('*/*/massDelete'),
        //        ));
        //        return $this;
    }
}
