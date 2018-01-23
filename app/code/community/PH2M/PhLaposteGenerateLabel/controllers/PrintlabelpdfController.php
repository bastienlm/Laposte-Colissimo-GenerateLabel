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
 * @author     PH2M | Bastien Lamamy (bastienlm)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class PH2M_PhLaposteGenerateLabel_PrintlabelpdfController extends Mage_Core_Controller_Front_Action {

    protected $_log;

    /**
     * @return Mage_Adminhtml_Controller_Action|Mage_Core_Controller_Varien_Action
     */
    public function downloadAction()
    {
        $orderId    = $this->getRequest()->getParam('order_id');
        $response   = Mage::helper('lapostegeneratelabel')->sendGenerateLabelApiRequest($orderId);
        $this->_initLog($orderId);


        if($response == false) {
            return $this->_returnNoResponseStatus();
        }

        if(strpos($response, '<soap:Fault>') !== false || strpos($response, '<type>ERROR</type>')) {
           return $this->_returnErrorStatus($response, $orderId);
        }

        return $this->_returnSuccessStatus($response, $orderId);
    }

    /**
     * @return Zend_Controller_Response_Abstract
     */
    public function downloadManualAction()
    {
        $file = Mage::getBaseDir('locale') . DS . Mage::app()->getLocale()->getLocaleCode()  . DS . 'pdf' . DS . 'exchangeandrefund.pdf';
        if(file_exists($file)) {
            $content = file_get_contents($file);
        } else {
            $content = file_get_contents(Mage::getBaseDir('locale') . DS . 'en_US'  . DS . 'pdf' . DS . 'exchangeandrefund.pdf');
        }


        return $this->getResponse()
            ->setHttpResponseCode(200)
            ->setHeader('Pragma', 'public', true)
            ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
            ->setHeader('Content-type', 'application/pdf', true)
            ->setHeader('Content-Length', strlen($content))
            ->setHeader('Last-Modified', date('r'))
            ->setBody($content);
    }

    public function viewAction()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn() && !Mage::getStoreConfig('general/laposte_returnlabel/enabled')) {
            $this->_redirectReferer();
            return;
        }
        $this->loadLayout();
        $this->_initLayoutMessages('core/session');
        $this->renderLayout();
    }


    public function exchangeAction()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn() && !Mage::getStoreConfig('general/laposte_returnlabel/enabled')) {
            $this->_redirectReferer();
            return;
        }
        $this->loadLayout();
        $this->_initLayoutMessages('core/session');
        $this->renderLayout();
    }

    /**
     * Init log model with order, customer and store
     *
     * @param $orderId
     */
    protected function _initLog($orderId)
    {
        $this->_log        = Mage::getModel('phlapostegeneratelabel/lapostegeneratelabel')
            ->setOrderId($orderId)
            ->setCustomerId(Mage::getSingleton('customer/session')->getId())
            ->setStoreId(Mage::app()->getStore()->getId())
        ;
    }

    /**
     * Return error message and set error status on log
     *
     * @return Mage_Core_Controller_Varien_Action
     */
    protected function _returnNoResponseStatus()
    {
        $this->_log->setStatus(PH2M_PhLaposteGenerateLabel_Model_Lapostegeneratelabel_Status::STATUS_FAIL_API);
        $this->_log->setMessageLog(Mage::helper('lapostegeneratelabel')->__('The API did not send a reply.'));
        try {
            $this->_log->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }
        Mage::getSingleton('core/session')->addError($this->__('You can do this for the moment.'));
        return $this->_redirectReferer();
    }

    /**
     * Return error detail message and add this on log
     *
     * @param $response
     * @param $orderId
     * @return Mage_Core_Controller_Varien_Action
     */
    protected function _returnErrorStatus($response, $orderId)
    {
        $this->_log->setStatus(PH2M_PhLaposteGenerateLabel_Model_Lapostegeneratelabel_Status::STATUS_FAIL_API);
        $message = '';

        // Get error message
        preg_match('/<messageContent>(.*)<\/messageContent>/', $response, $message);
        // Get error code
        preg_match('/<id>(.*)<\/id>/', $response, $code);

        $this->_log->setMessageLog(Mage::helper('lapostegeneratelabel')->__('The API return error message: %s, code: %s', $message[1], $code[1]));
        try {
            $this->_log->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }
        Mage::log('order_id: '. $orderId . PHP_EOL . $response . PHP_EOL . '--------------------' . PHP_EOL, Zend_log::ALERT, 'lapostegeneratelabel.log');
        if($errorMessage = Mage::helper('lapostegeneratelabel/error')->getErrorMessageByCode($code[1])) {
            Mage::getSingleton('core/session')->addError($errorMessage);
        } else {
            Mage::getSingleton('core/session')->addError($this->__('An error has occurred. Please contact-us for more details.'));
        }
        return $this->_redirectReferer();
    }


    /**
     * Return label pdf and add success on log
     *
     * @param $response
     * @param $orderId
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _returnSuccessStatus($response, $orderId)
    {
        // Remove useless xml header
        $response = preg_replace('/(.*)(%PDF)/s', '%PDF', $response);

        $this->_log->setStatus(PH2M_PhLaposteGenerateLabel_Model_Lapostegeneratelabel_Status::STATUS_SUCCESS);
        try {
            $this->_log->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }
        return $this->_prepareDownloadResponse('Label_' . $orderId . '.pdf', $response, 'application/pdf');
    }

}