<?php
namespace Bluecom\VendorList\Block;

use Magento\Framework\View\Element\Template;
use Bluecom\Vendor\Model\ResourceModel\Vendor\CollectionFactory;

class VendorList extends \Magento\Framework\View\Element\Template
{
    protected $_vendors;

    protected $_vendorCollectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    )
    {
        $this->_vendorCollectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    public function getVendors()
    {
        if (is_null($this->_vendors)) {
            $this->_vendors = $this->_vendorCollectionFactory->create();

            if ($dir = $this->getRequest()->getParam('dir')) {
                $this->_vendors->setOrder('name', $dir);
            }
        }
        return $this->_vendors;
    }

    public function getViewUrl($vendor)
    {
        return $this->getUrl('vendorlist/vendor/view', ['vendor_id' => $vendor->getId()]);
    }
}
