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
     * Return all order complete in FR
     *
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    public function listOfOrderAvailable() {

        $orders = Mage::getResourceModel('sales/order_collection')
            ->addAttributeToFilter('state', Mage_Sales_Model_Order::STATE_COMPLETE)
            ->addAttributeToFilter('customer_id', Mage::getSingleton('customer/session')->getId())
            ->addAttributeToFilter('country_id', array('in' => Mage::helper('lapostegeneratelabel')->countryAvailableForProductReturn()))
            ->join(array('ship_address' => 'order_address'), 'main_table.shipping_address_id = ship_address.entity_id', 'country_id')
            ;


        return $orders;


    }

}