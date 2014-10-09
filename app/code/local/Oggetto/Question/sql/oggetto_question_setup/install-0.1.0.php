<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 03.10.14
 * Time: 1:00
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

Mage::log('table: ' . $installer->getTable('question/question'));
try {
    $table = $installer->getConnection()->newTable($installer->getTable('question/question'))
        ->addColumn('id',         Varien_Db_Ddl_Table::TYPE_INTEGER,  null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
            ), 'Id'
        )
        ->addColumn('name',       Varien_Db_Ddl_Table::TYPE_TEXT,     255,  array(), 'Sender name')
        ->addColumn('email',      Varien_Db_Ddl_Table::TYPE_TEXT,     255,  array(), 'Sender email')
        ->addColumn('question',   Varien_Db_Ddl_Table::TYPE_TEXT,     null, array(), 'Question text')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(), 'Created at')
        ->addColumn('answer',     Varien_Db_Ddl_Table::TYPE_TEXT,     null, array(), 'Answer')
        ->addColumn('status',     Varien_Db_Ddl_Table::TYPE_INTEGER,  null, array('default' => 0), 'Created at')
        ;
//    var_dump($table);die;
    $installer->getConnection()->createTable($table);
} catch (Exception $e) {
    Mage::printException($e);
    Mage::logException($e);
}

$installer->endSetup();