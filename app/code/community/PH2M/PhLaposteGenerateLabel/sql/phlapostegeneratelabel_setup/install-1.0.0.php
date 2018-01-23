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
 * @copyright  Copyright (c) 2016 PH2M
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
/* @var $installer PH2M_PhLapostegeneratelabel_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'phlapostegeneratelabel/lapostegeneratelabel'
 */

$table = $installer->getConnection()
    ->newTable($installer->getTable('phlapostegeneratelabel/lapostegeneratelabel'))
    ->addColumn('lapostegeneratelabel_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
		'unsigned'  => true,
        ), 'ID')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Title')
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Title')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
    ), 'Status')
    ->addColumn('creation_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Creation Time')
    ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Modification Time')
    ->setComment('lapostegeneratelabels Table');
$installer->getConnection()->createTable($table);

/**
 * Create table 'phlapostegeneratelabel/lapostegeneratelabel_store'
 */

$table = $installer->getConnection()
    ->newTable($installer->getTable('phlapostegeneratelabel/lapostegeneratelabel_store'))
    ->addColumn('lapostegeneratelabel_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'Block ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($installer->getIdxName('phlapostegeneratelabel/lapostegeneratelabel_store', array('store_id')),
        array('store_id'))
    ->addForeignKey($installer->getFkName('phlapostegeneratelabel/lapostegeneratelabel_store', 'lapostegeneratelabel_id', 'phlapostegeneratelabel/lapostegeneratelabel', 'lapostegeneratelabel_id'),
        'lapostegeneratelabel_id', $installer->getTable('phlapostegeneratelabel/lapostegeneratelabel'), 'lapostegeneratelabel_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('phlapostegeneratelabel/lapostegeneratelabel_store', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('lapostegeneratelabels To Store Linkage Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
