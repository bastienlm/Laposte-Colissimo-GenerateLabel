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

/**
 * PH2M_Lapostegeneratelabel extension
 *
 * @category   PH2M
 * @package    PH2M_Lapostegeneratelabel
 * @author     PH2M Dev Team
 */

class PH2M_PhLaposteGenerateLabel_Model_Lapostegeneratelabel_Source extends Varien_Object {

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = array();
        $collection = $this->_getCollection();

        foreach($collection as $lapostegeneratelabel) {
            $options[] = array(
                'value' => $lapostegeneratelabel->getLapostegeneratelabelId(),
                'label' => $lapostegeneratelabel->getName()
            );
        }

        return $options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $options = array();
        $collection = $this->_getCollection();

        foreach($collection as $lapostegeneratelabel) {
            $options[$lapostegeneratelabel->getLapostegeneratelabelId()] = $lapostegeneratelabel->getName();
        }

        return $options;
    }

    protected function _getCollection() {
        /* @var $collection PH2M_PhLapostegeneratelabel_Model_Resource_Lapostegeneratelabel_Collection */
        $collection = Mage::getResourceModel('phlapostegeneratelabel/lapostegeneratelabel_collection');

        // Filter on active lapostegeneratelabel
        $collection->addActiveFilter();

        // Sort by position
        $collection->setOrder('position', 'ASC');

        return $collection;
    }
}
