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


class PH2M_PhLaposteGenerateLabel_Model_Resource_Lapostegeneratelabel_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

    /**
     * Load data for preview flag
     *
     * @var bool
     */
    protected $_previewFlag;


    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('phlapostegeneratelabel/lapostegeneratelabel');
        $this->_map['fields']['lapostegeneratelabel_id'] = 'main_table.lapostegeneratelabel_id';
        $this->_map['fields']['store']   = 'store_table.store_id';
    }

    /**
     * deprecated after 1.4.0.1, use toOptionIdArray()
     * @deprecated
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('identifier', 'title');
    }

    /**
     * Set first store flag
     *
     * @param bool $flag
     * @return PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel_Collection
     */
    public function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;
        return $this;
    }

    /**
     * Perform operations after collection load
     *
     * @return PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel_Collection
     */
    protected function _afterLoad()
    {
        if ($this->_previewFlag) {
            $items = $this->getColumnValues('lapostegeneratelabel_id');
            $connection = $this->getConnection();
            if (count($items)) {
                $select = $connection->select()
                        ->from(array('mis'=>$this->getTable('phlapostegeneratelabel/lapostegeneratelabel_store')))
                        ->where('mis.lapostegeneratelabel_id IN (?)', $items);

                if ($result = $connection->fetchPairs($select)) {
                    foreach ($this as $item) {
                        if (!isset($result[$item->getData('lapostegeneratelabel_id')])) {
                            continue;
                        }
                        if ($result[$item->getData('lapostegeneratelabel_id')] == 0) {
                            $stores = Mage::app()->getStores(false, true);
                            $storeId = current($stores)->getId();
                            $storeCode = key($stores);
                        } else {
                            $storeId = $result[$item->getData('lapostegeneratelabel_id')];
                            $storeCode = Mage::app()->getStore($storeId)->getCode();
                        }
                        $item->setData('_first_store_id', $storeId);
                        $item->setData('store_code', $storeCode);
                    }
                }
            }
        }

        return parent::_afterLoad();
    }

    /**
     * Add filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @param bool $withAdmin
     * @return PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel_Collection
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }

            if (!is_array($store)) {
                $store = array($store);
            }

            if ($withAdmin) {
                $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
            }

            $this->addFilter('store', array('in' => $store), 'public');
        }
        return $this;
    }

    /**
     * Join store relation table if there is store filter
     */
    protected function _renderFiltersBefore()
    {
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                array('store_table' => $this->getTable('phlapostegeneratelabel/lapostegeneratelabel_store')),
                'main_table.lapostegeneratelabel_id = store_table.lapostegeneratelabel_id',
                array()
            )->group('main_table.lapostegeneratelabel_id');

            /*
             * Allow analytic functions usage because of one field grouping
             */
            $this->_useAnalyticFunction = true;
        }
        return parent::_renderFiltersBefore();
    }


    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();

        $countSelect->reset(Zend_Db_Select::GROUP);

        return $countSelect;
    }
    
    /**
     * Filter by websites
     * @param array $websiteIds
     */
    public function addWebsiteFilter($websiteIds) {
    	// Join machine_store table
    	$tableName = Mage::getSingleton('core/resource')->getTableName('phlapostegeneratelabel/lapostegeneratelabel_store');
    	$this->getSelect()->join(array('lapostegeneratelabel_store' => $tableName), 'main_table.lapostegeneratelabel_id = lapostegeneratelabel_store.lapostegeneratelabel_id', array(''));
    
    	// Join core_store table
    	$tableName = Mage::getSingleton('core/resource')->getTableName('core/store');
    	$this->getSelect()->join(array('core_store' => $tableName), 'lapostegeneratelabel_store.store_id = core_store.store_id', array(''));
    	$this->addFieldToFilter('core_store.website_id', array('in' => $websiteIds));
    
    	return $this;
    }
    
    /**
     * Select only active blocks
     * @return PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel_Collection
     */
    public function addActiveFilter() {
    	$this->addFieldToFilter('is_active', '1');
    
    	return $this;
    }
    
    /**
     * Add filter by blocks
     *
     * @param array $blockIds
     * @param bool $exclude
     * @return PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel_Collection
     */
    public function addBlockIdsFilter($blockIds, $exclude = false)
    {
    	$this->addFieldToFilter('main_table.lapostegeneratelabel_id', array(($exclude ? 'nin' : 'in') => $blockIds));
    	return $this;
    }
    
	/**
     * Add attribute to sort order
     *
     * @param string $attribute
     * @return PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel_Collection
     */
    public function addSortByIds($ids = array())
    {
    	if (count($ids)) {
			$sortOrder = $this->getConnection()->quoteInto('FIELD(main_table.lapostegeneratelabel_id, ?)', $ids);
			$this->getSelect()->order($sortOrder);
    	}
    	return $this;
    }
}
