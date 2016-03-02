<?php
namespace Bluecom\VendorList\Block;

use Magento\Framework\Registry;

class VendorView extends \Magento\Catalog\Block\Product\AbstractProduct
{

    protected $_coreRegistry;

    protected $_productCollection;

    protected $_productCollectionFactory;

    protected $_catalogConfig;

    protected $_catalogProductVisibility;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        Registry $registry,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_catalogConfig = $context->getCatalogConfig();
        $this->_catalogProductVisibility = $catalogProductVisibility;

        parent::__construct($context, $data);
    }

    public function getVendor()
    {
        return $this->_coreRegistry->registry('vendor');
    }

    public function getLoadedProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $this->_productCollection = $this->_productCollectionFactory->create()
                ->addAttributeToSelect($this->_catalogConfig->getProductAttributes())
                ->addMinimalPrice()
                ->addFinalPrice()
                ->addTaxPercents()
                ->addUrlRewrite()
                ->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds())
                ->addIdFilter($this->getVendor()->getAssignedProductIds());
        }
        return $this->_productCollection;
    }
}
