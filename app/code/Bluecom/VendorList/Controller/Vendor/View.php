<?php
namespace Bluecom\VendorList\Controller\Vendor;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

class View extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    protected $_coreRegistry;

    protected $_resultForwardFactory;

    protected $_vendorFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Bluecom\Vendor\Model\VendorFactory $vendorFactory
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->_resultForwardFactory = $resultForwardFactory;
        $this->_vendorFactory = $vendorFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        $vendorId = $this->getRequest()->getParam('vendor_id');
        $vendor = $this->_vendorFactory->create()->load($vendorId);
        if (!$vendor->getId()) {
            $resultForward = $this->_resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        $this->_coreRegistry->register('vendor', $vendor);
        $resultPage->getConfig()->getTitle()->set(__($vendor->getName()));
        return $resultPage;
    }
}