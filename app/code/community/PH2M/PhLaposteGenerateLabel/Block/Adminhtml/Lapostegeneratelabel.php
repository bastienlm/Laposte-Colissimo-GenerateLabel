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

class PH2M_PhLaposteGenerateLabel_Block_Adminhtml_Lapostegeneratelabel extends Mage_Adminhtml_Block_Widget_Grid_Container {

    /**
     * Block constructor
     */
    public function __construct()
    {
    	
        $this->_controller = 'adminhtml_lapostegeneratelabel';
        $this->_headerText = Mage::helper('lapostegeneratelabel')->__('Manage Lapostegeneratelabels');
		$this->_blockGroup = 'phlapostegeneratelabel';

        parent::__construct();

            $this->_removeButton('add');

    }

    /**
     * Render grid
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

    public function getHeaderCssClass()
    {
        return 'head-products icon-head icon-head-lapostegeneratelabel-items ' .
        	Mage_Adminhtml_Block_Widget_Container::getHeaderCssClass();
    }
    

    /**
     * Check whether it is single store mode
     *
     * @return bool
     */
    public function isSingleStoreMode()
    {
        if (!Mage::app()->isSingleStoreMode()) {
               return false;
        }
        return true;
    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
    	return Mage::getSingleton('admin/session')->isAllowed('cms/phlapostegeneratelabel/' . $action);
    }

}

