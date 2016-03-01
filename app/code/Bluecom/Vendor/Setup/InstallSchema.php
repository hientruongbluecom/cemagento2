<?php
namespace Bluecom\Vendor\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('training4_vendor'))
            ->addColumn(
                'vendor_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Vendor ID'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Vendor Name'
            )->setComment('Vendor Table');

        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()
            ->newTable($installer->getTable('training4_vendor2product'))
            ->addColumn(
                'vendor_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'primary' => true, 'nullable' => false],
                'Vendor ID'
            )->addColumn(
                'product_id',
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'primary' => true, 'nullable' => false],
                'Product ID'
            )->addIndex(
                $installer->getIdxName('training4_vendor2product', ['product_id']),
                ['product_id']
            )->addForeignKey(
                $installer->getFkName('training4_vendor2product', 'product_id', 'catalog_product_entity', 'entity_id'),
                'product_id',
                $installer->getTable('catalog_product_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('training4_vendor2product', 'vendor_id', 'training4_vendor', 'vendor_id'),
                'vendor_id',
                $installer->getTable('training4_vendor'),
                'vendor_id',
                Table::ACTION_CASCADE
            )->setComment(
                'Vendor To Product Table'
            );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}