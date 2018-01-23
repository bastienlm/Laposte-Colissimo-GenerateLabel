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


class PH2M_PhLaposteGenerateLabel_Model_Abstract extends Mage_Core_Model_Abstract {

    protected $_firstNodeName = 'REPLACE_ME';

    public function transformDataToXml($label) {
        foreach ($this->getData() as $secondNode => $secondNodeData) {
            if(is_array($secondNodeData)) {

                foreach ($secondNodeData as $thirdNode => $thirdNodeData) {
                    $thirdNode = preg_replace_callback('/_(.){1}/i',function ($match) {return strtoupper($match[1]);}, $thirdNode);
                    $label->setNode($this->_firstNodeName . DS . $secondNode . DS . $thirdNode, $thirdNodeData);
                }
            } else {

                $secondNode = preg_replace_callback('/_(.){1}/i',function ($match) {return strtoupper($match[1]);}, $secondNode);
                $label->setNode($this->_firstNodeName . DS . $secondNode, $secondNodeData);
            }
        }

    }
}