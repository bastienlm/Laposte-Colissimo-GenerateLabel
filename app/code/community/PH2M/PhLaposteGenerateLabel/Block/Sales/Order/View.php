<?php
/**
 * PH2M_PhLaposteGenerateLabel
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   LaposteGenerateLabel
 * @copyright  Copyright (c) 2017 PH2M SARL
 * @author     PH2M | Bastien Lamamy (bastienlm) bastien-lamamy.com/
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class PH2M_PhLaposteGenerateLabel_Block_Sales_Order_View extends Mage_Core_Block_Template {

    /**
     * Retrieve current order model instance
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        return Mage::registry('current_order');
    }


    /**
     * @return bool
     */
    public function canShowButton() {
        if($this->getOrder()->getStatus() == 'complete'
            && $this->getOrder()->getShippingAddress()->getCountryId() == 'FR'
        && $this->getOrder()->getCustomerId() == Mage::getSingleton('customer/session')->getId()) {
            return true;
        } else {
            return false;
        }
    }

}