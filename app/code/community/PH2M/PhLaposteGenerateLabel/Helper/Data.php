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

class PH2M_PhLaposteGenerateLabel_Helper_Data extends Mage_Core_Helper_Abstract {

    protected $_label;
    protected $_xmlPath;


    /**
     * Init label with structure xml file
     *
     * PH2M_PhLaposteGenerateLabel_Helper_Data constructor.
     */
    public function __construct() {
        if(!$this->_label) {
            $this->_xmlPath         = Mage::getConfig()->getModuleDir('etc', 'PH2M_PhLaposteGenerateLabel') . DS . 'struct.xml';
            $xmlObj                 = new Varien_Simplexml_Config($this->_xmlPath);
            $this->_label           = $xmlObj->getNode();
        }
    }

    /**
     * Convert model data to xml
     */
    public function generateLetterNode($orderId, $customerShippingAddress) {
        $letter = $this->getLetter($orderId, $customerShippingAddress);
        foreach ($letter->getData() as $firstNode => $firstNodeData) {
            $firstNode = preg_replace_callback('/_(.){1}/i',function ($match) {return strtoupper($match[1]);}, $firstNode);
            $firstNode = 'letter/' . $firstNode;

            if(is_object($firstNodeData)) {
                $firstNodeData->transformDataToXml($this->_label);
            } else {
                $this->_label->setNode($firstNode, $firstNodeData);
            }
        }
    }


    /**
     * Convert identifier data to xml
     */
    public function initIdentifier() {
        $this->_label->setNode('contractNumber', Mage::getStoreConfig('general/laposte_returnlabel/contract_number'));
        $this->_label->setNode('password', Mage::getStoreConfig('general/laposte_returnlabel/password'));
    }

    /**
     * Convert model data to xml
     */
    public function generateOutputFormatNode() {
        $output = $this->getOutputFormat();
        foreach ($output->getData() as $firstNode => $firstNodeData) {
            $firstNode = preg_replace_callback('/_(.){1}/i',function ($match) {return strtoupper($match[1]);}, $firstNode);
            $this->_label->setNode('outputFormat/' . $firstNode, $firstNodeData);
        }
    }

    /**
     * Save output format in model
     *
     * @return Mage_Core_Model_Abstract|PH2M_PhLaposteGenerateLabel_Model_Outputformat
     */
    public function getOutputFormat() {
        $output =  Mage::getSingleton('lapostegeneratelabel/outputformat');
        $output->setX('0');
        $output->setY('0');
        $output->setOutputPrintingType('PDF_A4_300dpi');
        return $output;
    }


    /**
     * Save letter data in model
     *
     * @param $orderId
     * @param $customerShippingAddress Mage_Sales_Model_Order_Address
     * @return Mage_Core_Model_Abstract|PH2M_PhLaposteGenerateLabel_Model_Letter
     */
    public function getLetter($orderId, $customerShippingAddress) {
        /** @var $items Mage_Sales_Model_Order_Item */

        $order  = Mage::getModel('sales/order')->load($orderId);
        $letter = Mage::getSingleton('lapostegeneratelabel/letter');

        $service = Mage::getSingleton('lapostegeneratelabel/letter_service');
        $service->setProductCode('CORE');
        $service->setDepositDate(Mage::getModel('core/date')->date('Y-m-d'));
        $service->setMailBoxPicking('false');
        $service->setTransportationAmount(0);
        $service->setTotalAmount(0);
        $service->setOrderNumber($order->getIncrementId());
        $service->setCommercialName();
        $service->setReturnTypeChoice(3);

        $weight = 0;
        $items  = $order->getAllVisibleItems();
        foreach ($items as $item) {
            $weight += $item->getWeight();
        }
        $parcel = Mage::getSingleton('lapostegeneratelabel/letter_parcel');
        $parcel->setWeight($weight);
        $parcel->setNonMachinable('false');
        $parcel->setInstructions();
        $parcel->setPickupLocationId();

        $customsDeclarations = Mage::getSingleton('lapostegeneratelabel/letter_customsdelcarations');
        $customsDeclarations->setIncludeCustomsDeclarations('false');
        $customsDeclarations->setContents();

        $sender = Mage::getSingleton('lapostegeneratelabel/letter_sender');
        $sender->setSenderParcelRef();
        $sender->setAddress(
            array(
                'companyName'       => $customerShippingAddress->getCompany(),
                'lastName'          => $customerShippingAddress->getLastname(),
                'firstName'         => $customerShippingAddress->getFirstname(),
                'line0'             => $customerShippingAddress->getStreet3(),
                'line1'             => $customerShippingAddress->getStreet4(),
                'line2'             => $customerShippingAddress->getStreet1(),
                'line3'             => $customerShippingAddress->getStreet2(),
                'countryCode'       => $customerShippingAddress->getCountryId(),
                'city'              => $customerShippingAddress->getCity(),
                'zipCode'           => $customerShippingAddress->getPostcode(),
                'phoneNumber'       => $customerShippingAddress->getTelephone(),
                'mobileNumber'      => $customerShippingAddress->getTelephone(),
                'doorCode1'         => '',
                'doorCode2'         => '',
                'email'             => $customerShippingAddress->getEmail(),
                'intercom'          => '',
                'language'          => $customerShippingAddress->getCountryId(),
            )
        );


        $addressee = Mage::getSingleton('lapostegeneratelabel/letter_addressee');
        $addressee->setAddresseeParcelRef();
        $addressee->setCodeBarForReference(0);
        $addressee->setServiceInfo();
        $addressee->setAddress(
            array(
                'companyName'       => Mage::getStoreConfig('general/laposte_returnlabel/compagny_name'),
                'lastName'          => Mage::getStoreConfig('general/laposte_returnlabel/last_name'),
                'firstName'         => Mage::getStoreConfig('general/laposte_returnlabel/first_name'),
                'line0'             => '',
                'line1'             => '',
                'line2'             => Mage::getStoreConfig('general/laposte_returnlabel/street_line1'),
                'line3'             => Mage::getStoreConfig('general/laposte_returnlabel/street_line2'),
                'countryCode'       => Mage::getStoreConfig('general/laposte_returnlabel/country_code'),
                'city'              => Mage::getStoreConfig('general/laposte_returnlabel/city'),
                'zipCode'           => Mage::getStoreConfig('general/laposte_returnlabel/zip_code'),
                'phoneNumber'       => Mage::getStoreConfig('general/laposte_returnlabel/phone_number'),
                'mobileNumber'      => Mage::getStoreConfig('general/laposte_returnlabel/phone_number'),
                'doorCode1'         => '',
                'doorCode2'         => '',
                'email'             => Mage::getStoreConfig('general/laposte_returnlabel/email'),
                'intercom'          => '',
                'language'          => Mage::getStoreConfig('general/laposte_returnlabel/country_code'),
            )
        );

        $letter->setService($service);
        $letter->setParcel($parcel);
        $letter->setCustomsDeclarations($customsDeclarations);
        $letter->setSender($sender);
        $letter->setAddressee($addressee);

        return $letter;
    }


    /**
     *
     * Send api request thanks to curl
     *
     * @param $orderId
     * @return mixed
     */
    public function sendGenerateLabelApiRequest($orderId) {
        $order = Mage::getModel('sales/order')->load($orderId);
        if(!$order || !$order->getId() || $order->getState() != Mage_Sales_Model_Order::STATE_COMPLETE || $order->getCustomerId() != Mage::getSingleton('customer/session')->getId()) {
            return false;
        }
        $customerShippingAddress = $order->getShippingAddress();

        if($customerShippingAddress->getCountryId() != 'FR') {
            return false;
        }

        $this->initIdentifier();
        $this->generateOutputFormatNode();
        $this->generateLetterNode($orderId, $customerShippingAddress);

        // Convert Xml data to correct format
        $xmlData = $this->_label->asNiceXml();

        $body       = '<?xml version="1.0" encoding="utf-8"?>
                            <x:Envelope xmlns:x="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sls="http://sls.ws.coliposte.fr">
                                <x:Body>
                                    <sls:generateLabel>'
                                        . $xmlData .
                                    '</sls:generateLabel>
                                </x:Body>
                            </x:Envelope>';

        $soapUrl            = "https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl";
        $headers            = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
        );
        $headers[] = "Content-length: ".strlen($body);



        $url = $soapUrl;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        return $response;
    }


    /**
     * @return string
     */
    public function getDownloadControllerUrl() {
        return Mage::getUrl('phlaposte/printlabelpdf/download/');
    }

    /**
     * @return string
     */
    public function getViewControllerUrl() {
        return Mage::getUrl('phlaposte/printlabelpdf/view/');
    }
}
