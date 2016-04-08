<?php
namespace Bluecom\BannerSlider\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package Bluecom\BannerSlider\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        /**
         * Slider Banner
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('bc_slider'))
            ->addColumn(
                'slider_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                10,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Slider ID'
            )->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false, 'default' => ''],
                'Slider title'
            )->addColumn(
                'show_title',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => true, 'default' => '1'],
                'Show Title'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '1'],
                'Slider status'
            )->addColumn(
                'description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Slider description'
            )->setComment(
                'Slider Table'
            )->addIndex(
                $installer->getIdxName('bc_slider', ['slider_id']),
                ['slider_id']
            )->addIndex(
                $installer->getIdxName('bc_slider', ['title']),
                ['title']
            )->addIndex(
                $installer->getIdxName('bc_slider', ['status']),
                ['status']
            );
        $installer->getConnection()->createTable($table);

        /**
         * Items Banner of Slider
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('bc_banner'))
            ->addColumn(
                'banner_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                10,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Banner ID'
            )->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false, 'default' => ''],
                'Banner name'
            )->addColumn(
                'slider_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                10,
                ['nullable' => true],
                'Slider Id'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '1'],
                'Banner status'
            )->addColumn(
                'url',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => true, 'default' => ''],
                'Banner url'
            )->addColumn(
                'image',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Banner image'
            )->addColumn(
                'image_alt',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Banner image alt'
            )->addColumn(
                'description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Banner description'
            )->addColumn(
                'start_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Banner starting time'
            )->addColumn(
                'end_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Banner ending time'
            )->setComment(
                'Items Banner Of Slider'
            )->addIndex(
                $installer->getIdxName('bc_banner', ['banner_id']),
                ['banner_id']
            )->addIndex(
                $installer->getIdxName('bc_banner', ['name']),
                ['name']
            )->addIndex(
                $installer->getIdxName('bc_banner', ['status']),
                ['status']
            )->addIndex(
                $installer->getIdxName('bc_banner', ['url']),
                ['url']
            );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}