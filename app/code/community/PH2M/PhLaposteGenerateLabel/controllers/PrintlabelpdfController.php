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

class PH2M_PhLaposteGenerateLabel_PrintlabelpdfController extends Mage_Core_Controller_Front_Action {

    public function downloadAction() {
        $orderId = $this->getRequest()->getParam('order_id');
        $response = Mage::helper('lapostegeneratelabel')->sendGenerateLabelApiRequest($orderId);

        if($response == false) {
            Mage::getSingleton('core/session')->addError($this->__('You can do this for the moment.'));
            return $this->_redirectReferer();
        }

        if(strpos($response, '<soap:Fault>') !== false || strpos($response, '<type>ERROR</type>')) {
            Mage::log($response, Zend_log::ALERT);
            Mage::getSingleton('core/session')->addError($this->__('An error has occurred'));
            return $this->_redirectReferer();
        }
        return $this->_prepareDownloadResponse('etiquette.pdf', $response);
    }
    
    public function downloadManualAction() {
        $file = Mage::getBaseDir('locale') . DS . Mage::app()->getLocale()->getLocaleCode()  . DS . 'pdf' . DS . 'exchangeandrefund.pdf';
        if(file_exists($file)) {
            $content = file_get_contents($file);
        } else {
            $content = file_get_contents(Mage::getBaseDir('locale') . DS . 'en_US'  . DS . 'pdf' . DS . 'exchangeandrefund.pdf');
        }
        return $this->_prepareDownloadResponse($this->__('refund') . 'pdf', $content);
    }

    public function viewAction() {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirectReferer();
            return;
        }
        $this->loadLayout();
        $this->_initLayoutMessages('core/session');

        $this->renderLayout();
    }
}