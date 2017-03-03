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
 *
 * @method PH2M_PhLaposteGenerateLabel_Model_Outputformat setService(PH2M_PhLaposteGenerateLabel_Model_Letter_Service $value)
 * @method PH2M_PhLaposteGenerateLabel_Model_Letter_Service getService()
 * @method PH2M_PhLaposteGenerateLabel_Model_Outputformat setParcel(PH2M_PhLaposteGenerateLabel_Model_Letter_Parcel $value)
 * @method PH2M_PhLaposteGenerateLabel_Model_Letter_Parcel getParcel()
 * @method PH2M_PhLaposteGenerateLabel_Model_Outputformat setCustomsDeclarations(PH2M_PhLaposteGenerateLabel_Model_Letter_Customsdelcarations $value)
 * @method PH2M_PhLaposteGenerateLabel_Model_Letter_Customsdelcarations getCustomsDeclarations()
 * @method PH2M_PhLaposteGenerateLabel_Model_Outputformat setSender(PH2M_PhLaposteGenerateLabel_Model_Letter_Sender $value)
 * @method PH2M_PhLaposteGenerateLabel_Model_Letter_Sender getSender()
 * @method PH2M_PhLaposteGenerateLabel_Model_Outputformat setAddressee(PH2M_PhLaposteGenerateLabel_Model_Letter_Addressee $value)
 * @method PH2M_PhLaposteGenerateLabel_Model_Letter_Addressee getAddressee()
 */

class PH2M_PhLaposteGenerateLabel_Model_Letter extends Mage_Core_Model_Abstract {
    protected $_firstNodeName = 'letter';
}