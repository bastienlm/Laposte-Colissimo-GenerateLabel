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

class PH2M_PhLaposteGenerateLabel_Model_Lapostegeneratelabel_Status extends Varien_Object {
	
    const STATUS_SUCCESS	= 1;
    const STATUS_FAIL_API	= 2;

    /**
     * Prepare lapostegeneratelabel statuses
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        $statuses = new Varien_Object(array(
            self::STATUS_SUCCESS  => Mage::helper('lapostegeneratelabel')->__('Success'),
            self::STATUS_FAIL_API => Mage::helper('lapostegeneratelabel')->__('Fail api'),
        ));
        return $statuses->getData();
    }
    
}
