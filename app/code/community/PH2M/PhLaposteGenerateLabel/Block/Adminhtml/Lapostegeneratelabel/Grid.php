<?php
/**
 * PH2M_Lapostegeneratelabel Extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   PH2M
 * @copyright  Copyright (c) 2016 PH2M
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class PH2M_PhLaposteGenerateLabel_Block_Adminhtml_Lapostegeneratelabel_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    /**
     * Grid constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('phlapostegeneratelabel_lapostegeneratelabel_grid');
        $this->setDefaultSort('lapostegeneratelabel_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Get store
     */
    protected function _getStore()
    {
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    /**
     * Prepare collection
     */
    protected function _prepareCollection()
    {
        $store = $this->_getStore();
    	
        $collection = Mage::getModel('phlapostegeneratelabel/lapostegeneratelabel')
        	->getCollection();
        /* @var $collection PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel_Collection */
        	
        if ($store->getId()) {
            $collection->addStoreFilter($store);
        }
        $this->setCollection($collection);
		
        return parent::_prepareCollection();
    }

    /**
     * Prepare columns
     */
    protected function _prepareColumns()
    {
        $store = $this->_getStore();


        $this->addColumn('lapostegeneratelabel_id', array(
            'header'    => Mage::helper('lapostegeneratelabel')->__('ID'),
            'width'		=> '50px',
            'type'		=> 'number',
            'index'     => 'lapostegeneratelabel_id',
        ));
        $this->addColumn('customer_id', array(
            'header'    => Mage::helper('lapostegeneratelabel')->__('Customer ID'),
            'width'		=> '100px',
            'index'     => 'customer_id',
        ));
        $this->addColumn('order_id', array(
            'header'    => Mage::helper('lapostegeneratelabel')->__('Order ID'),
            'width'		=> '100px',
            'index'     => 'order_id',
        ));
        $this->addColumn('status', array(
            'header'    => Mage::helper('phfullscreen')->__('Status'),
            'index'     => 'status',
            'type'      => 'options',
            'width'		=> '100px',

            'options'   => Mage::getSingleton('phlapostegeneratelabel/lapostegeneratelabel_status')->getAvailableStatuses(),
        ));
        $this->addColumn('message_log', array(
            'header'    => Mage::helper('lapostegeneratelabel')->__('Log Message'),
            'width'		=> '400px',
            'index'     => 'message_log',
        ));

        $this->addColumn('creation_time', array(
            'header'            => Mage::helper('lapostegeneratelabel')->__('Created At'),
            'width'		        => '100px',
            'index'             => 'creation_time',
            'type'              => 'datetime',
            'filter_index'      => 'orders_alias.creation_time',
            'frame_callback'    => array( $this,'styleDate' )
        ));



        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('lapostegeneratelabel')->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'
                                => array($this, '_filterStoreCondition'),
            ));
        }

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            $this->addColumn('action_edit', array(
                'header'    => $this->helper('catalog')->__('Action'),
                'width'     => 15,
                'sortable'  => false,
                'filter'    => false,
                'type'      => 'action',
                'getter'    => 'getOrderId',
                'actions'   => array(
                    array(
                        'caption'   => $this->helper('lapostegeneratelabel')->__('View Order'),
                        'url'       => ['base' => 'adminhtml/sales_order/view'],
                        'field'     => 'order_id'
                    ),
                )
            ));
        }
        return parent::_prepareColumns();
    
    }
    
	/**
	 * Massaction for removing items
	 * 
	 * @return void
	 */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('key_id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'     =>  Mage::helper('lapostegeneratelabel')->__('Delete'),
            'url'       =>  $this->getUrl('*/*/massDelete'),
            'confirm'   =>  Mage::helper('lapostegeneratelabel')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('phlapostegeneratelabel/lapostegeneratelabel_status')->getAvailableStatuses();
        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
            'label'         =>  Mage::helper('lapostegeneratelabel')->__('Change status'),
            'url'           =>  $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional'    =>  array(
                'visibility'  =>  array(
                    'name'      =>  'status',
                    'type'      =>  'select',
                    'class'     =>  'required-entry',
                    'label'     =>  Mage::helper('lapostegeneratelabel')->__('Status'),
                    'values'    =>  $statuses
                )
            )
        ));
        
        return $this;
    }

    public function styleDate( $value,$row,$column,$isExport )
    {
        $locale = Mage::app()->getLocale();
        $date = $locale->date( $value, $locale->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM), $locale->getLocaleCode(), false )->toString( $locale->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM) ) ;
        return $date;
    }

    /**
     * _afterLoadCollection
     *
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addStoreFilter($value);
    }

    
}
