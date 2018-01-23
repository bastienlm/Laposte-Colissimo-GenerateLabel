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


class PH2M_PhLaposteGenerateLabel_Adminhtml_LapostegeneratelabelController extends Mage_Adminhtml_Controller_Action {
	
    /**
     * Init actions
     *
     * @return PH2M_Lapostegeneratelabel_Adminhtml_LapostegeneratelabelController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('cms/phLapostegeneratelabel')
            ->_addBreadcrumb(Mage::helper('cms')->__('CMS'), Mage::helper('cms')->__('CMS'))
            ->_addBreadcrumb(Mage::helper('lapostegeneratelabel')->__('Lapostegeneratelabels'), Mage::helper('lapostegeneratelabel')->__('Lapostegeneratelabels'))
        ;
        return $this;
    }

    /**
     * Index action
	 * 
	 * @return void
     */
	public function indexAction()
	{
        $this->_title($this->__('CMS'))
             ->_title(Mage::helper('lapostegeneratelabel')->__('Lapostegeneratelabels'));

        if($this->getRequest()->getParam('ajax')) {
            $this->_forward('grid');
            return;
        }

        $this->_initAction();
        $this->renderLayout();
	}

	/**
	 * Items grid (used by Ajax)
     *
     * @return PH2M_Lapostegeneratelabel_Adminhtml_LapostegeneratelabelController
	 */
    public function gridAction()
    {
        $this->getResponse()->setBody(
        	$this->getLayout()
        		 ->createBlock('phlapostegeneratelabel/adminhtml_lapostegeneratelabel_grid')
        		 ->toHtml()
        );
    }

    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array
     * @return array
     */
    protected function _filterPostData($data)
    {
        return $data;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName())
        {
            case 'new':
            case 'save':
                return Mage::getSingleton('admin/session')->isAllowed('cms/phLapostegeneratelabel/save');
                break;
            case 'delete':
                return Mage::getSingleton('admin/session')->isAllowed('cms/phLapostegeneratelabel/delete');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('cms/phLapostegeneratelabel');
                break;
        }
    }

}

