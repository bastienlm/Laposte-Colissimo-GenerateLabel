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
 *
 */

/**
 * @Class PH2M_PhLaposteGenerateLabel_Model_Lapostegeneratelabel
 * @method PH2M_PhLaposteGenerateLabel_Model_Lapostegeneratelabel setOrderId(int $orderId)
 * @method PH2M_PhLaposteGenerateLabel_Model_Lapostegeneratelabel setCustomerId(int $customerId)
 * @method PH2M_PhLaposteGenerateLabel_Model_Lapostegeneratelabel setStoreId(int $storeId)
 * @method PH2M_PhLaposteGenerateLabel_Model_Lapostegeneratelabel setMessageLog(string $message)
 * @method PH2M_PhLaposteGenerateLabel_Model_Lapostegeneratelabel setStatus(int $status)
 */
class PH2M_PhLaposteGenerateLabel_Model_Lapostegeneratelabel extends Mage_Core_Model_Abstract {
	
	const CACHE_TAG = 'phlapostegeneratelabel_lapostegeneratelabel';
	
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('phlapostegeneratelabel/lapostegeneratelabel');
    }
	
	/**
     * Get Absolute Image Url Path
     * @return string
     */
    public function getImageUrlPath() {
        return Mage::getBaseUrl(Mage_Core_Model_Store:: URL_TYPE_MEDIA) . $this->getImage();
    }
}
