<?php
/**
 * PH2M_lapostegeneratelabel Extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   PH2M
 * @copyright  Copyright (c) 2017 PH2M
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
/* @var $installer PH2M_PhLapostegeneratelabel_Model_Resource_Setup */

$installer->getConnection()
    ->addColumn($installer->getTable('phlapostegeneratelabel/lapostegeneratelabel'),'message_log', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable'  => true,
        'comment'   => 'Message LOG'
    ));