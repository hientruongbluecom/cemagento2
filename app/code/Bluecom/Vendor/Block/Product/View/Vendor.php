<?php
namespace Bluecom\Vendor\Block\Product\View;

use Magento\Framework\View\Element\Template;

class Vendor extends Template
{
    protected $_coreRegistry;
    protected $_vendorCollectionFactory;

    public function __construct(
        Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Bluecom\Vendor\Model\ResourceModel\Vendor\CollectionFactory $collectionFactory,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        $this->_vendorCollectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('product/view/vendor.phtml');
    }

    public function getCollection()
    {
        return $this->_vendorCollectionFactory->create()
            ->setProductFilter($this->_coreRegistry->registry('product'));
    }
}