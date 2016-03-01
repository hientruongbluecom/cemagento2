<?php
namespace Bluecom\Vendor\Setup;

use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\InstallDataInterface;

class InstallData implements InstallDataInterface
{
    protected $productFactory;

    /**
     * @param ProductFactory $productFactory
     */
    public function __construct(
        ProductFactory $productFactory
    )
    {
        $this->productFactory = $productFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $vendorsToInstalled = [];
        for ($i = 1; $i <= 20; $i++) {
            $vendorsToInstalled[] = ['name' => sprintf('Vendor %s', str_pad($i, 2, '0', STR_PAD_LEFT))];
        }

        $installer->getConnection()->insertArray(
            $installer->getTable('training4_vendor'),
            ['name'],
            $vendorsToInstalled
        );

        $select = $installer->getConnection()->select();
        $select->from($installer->getTable('training4_vendor'), ['vendor_id']);
        $vendorIds = $installer->getConnection()->fetchAll($select);

        $collection = $this->productFactory->create()->getCollection()
            ->addAttributeToFilter('status', ['in' => [Status::STATUS_ENABLED]])
            ->setVisibility([Visibility::VISIBILITY_IN_CATALOG, Visibility::VISIBILITY_BOTH]);

        foreach ($collection as $product) {
            $installer->getConnection()->insertArray(
                $installer->getTable('training4_vendor2product'),
                ['product_id', 'vendor_id'],
                $this->_getLinkArray($product->getId(), $vendorIds, array_rand($vendorIds, 5))
            );
        }

        $installer->endSetup();
    }

    protected function _getLinkArray($productId, $vendorIds, $randVendorIds)
    {
        $links = [];
        foreach ($randVendorIds as $vendorId) {
            $links[] = ['product_id' => $productId, 'vendor_id' => $vendorIds[$vendorId]['vendor_id']];
        }
        return $links;
    }
}