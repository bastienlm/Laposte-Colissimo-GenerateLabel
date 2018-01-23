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


class PH2M_PhLaposteGenerateLabel_Model_Resource_Lapostegeneratelabel extends Mage_Core_Model_Resource_Db_Abstract {
	
    /**
     * Store model
     *
     * @var null|Mage_Core_Model_Store
     */
    protected $_store  = null;
	
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('phlapostegeneratelabel/lapostegeneratelabel', 'lapostegeneratelabel_id');
    }

    /**
     * Process item data before deleting
     *
     * @param Mage_Core_Model_Abstract $lapostegeneratelabel
     * @return PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $lapostegeneratelabel)
    {
        $condition = array(
            'lapostegeneratelabel_id = ?'     => (int) $lapostegeneratelabel->getId(),
        );

        $this->_getWriteAdapter()->delete($this->getTable('phlapostegeneratelabel/lapostegeneratelabel_store'), $condition);

        return parent::_beforeDelete($lapostegeneratelabel);
    }

    /**
     * Process item data before saving
     *
     * @param Mage_Core_Model_Abstract $lapostegeneratelabel
     * @return PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $lapostegeneratelabel)
    {
        // modify create / update dates
        if ($lapostegeneratelabel->isObjectNew() && !$lapostegeneratelabel->hasCreationTime()) {
            $lapostegeneratelabel->setCreationTime(Mage::getSingleton('core/date')->gmtDate());
        }

        $lapostegeneratelabel->setUpdateTime(Mage::getSingleton('core/date')->gmtDate());

        return parent::_beforeSave($lapostegeneratelabel);
    }

    /**
     * Assign date to store views
     *
     * @param Mage_Core_Model_Abstract $lapostegeneratelabel
     * @return PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel
     */
    protected function _afterSave(Mage_Core_Model_Abstract $lapostegeneratelabel)
    {
        $oldStores = $this->lookupStoreIds($lapostegeneratelabel->getId());
        $newStores = (array)$lapostegeneratelabel->getStores();
        if (empty($newStores)) {
            $newStores = (array)$lapostegeneratelabel->getStoreId();
        }
        $table  = $this->getTable('phlapostegeneratelabel/lapostegeneratelabel_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = array(
                'lapostegeneratelabel_id = ?'     => (int) $lapostegeneratelabel->getId(),
                'store_id IN (?)' => $delete
            );

            $this->_getWriteAdapter()->delete($table, $where);
        }

        if ($insert) {
            $data = array();

            foreach ($insert as $storeId) {
                $data[] = array(
                    'lapostegeneratelabel_id'  => (int) $lapostegeneratelabel->getId(),
                    'store_id' => (int) $storeId
                );
            }

            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }

        return parent::_afterSave($lapostegeneratelabel);
    }

    /**
     * Perform operations after lapostegeneratelabel load
     *
     * @param Mage_Core_Model_Abstract $lapostegeneratelabel
     * @return PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $lapostegeneratelabel)
    {
        if ($lapostegeneratelabel->getId()) {
            $stores = $this->lookupStoreIds($lapostegeneratelabel->getId());

            $lapostegeneratelabel->setData('store_id', $stores);

        }
        return parent::_afterLoad($lapostegeneratelabel);
    }

    /**
     * Retrieve select lapostegeneratelabel for load lapostegeneratelabel data
     *
     * @param string $field
     * @param mixed $value
     * @param PH2M_PhLapostegeneratelabel_Model_Lapostegeneratelabel $lapostegeneratelabel
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $lapostegeneratelabel)
    {
        $select = parent::_getLoadSelect($field, $value, $lapostegeneratelabel);

        if ($lapostegeneratelabel->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$lapostegeneratelabel->getStoreId());
            $select->join(
                array('lapostegeneratelabel_store' => $this->getTable('phlapostegeneratelabel/lapostegeneratelabel_store')),
                $this->getMainTable() . '.lapostegeneratelabel_id = lapostegeneratelabel_store.lapostegeneratelabel_id',
                array())
                ->where('is_active = ?', 1)
                ->where('lapostegeneratelabel_store.store_id IN (?)', $storeIds)
                ->order('lapostegeneratelabel_store.store_id DESC')
                ->limit(1);
        }

        return $select;
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $itemId
     * @return array
     */
    public function lookupStoreIds($itemId)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getTable('phlapostegeneratelabel/lapostegeneratelabel_store'), 'store_id')
            ->where('lapostegeneratelabel_id = ?',(int)$itemId);

        return $adapter->fetchCol($select);
    }

    /**
     * Set store model
     *
     * @param Mage_Core_Model_Store $store
     * @return PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel
     */
    public function setStore($store)
    {
        $this->_store = $store;
        return $this;
    }

    /**
     * Retrieve store model
     *
     * @return Mage_Core_Model_Store
     */
    public function getStore()
    {
        return Mage::app()->getStore($this->_store);
    }
    
    /**
     * Get real existing block ids by specified ids
     *
     * @param array $blockIds
     * @param bool $isActive if true then only active banners will be get
     * @return array
     */
    public function getExistingBlockIdsBySpecifiedIds($blockIds, $isActive = true)
    {
    	$adapter = $this->_getReadAdapter();
    	$select = $adapter->select()
    	->from($this->getMainTable(), array('lapostegeneratelabel_id'))
    	->where('lapostegeneratelabel_id IN (?)', $blockIds);
    	if ($isActive) {
    		$select->where('is_active = ?', (int)$isActive);
    	}
    	return array_intersect($blockIds, $adapter->fetchCol($select));
    }
}
