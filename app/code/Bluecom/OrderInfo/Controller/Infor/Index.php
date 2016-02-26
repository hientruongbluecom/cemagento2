<?php
namespace Bluecom\OrderInfo\Controller\Infor;

use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\OrderFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Registry;

class Index extends \Bluecom\OrderController\Controller\Infor\Index
{
    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    public function __construct(
        Context $context,
        OrderFactory $orderFactory,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        Registry $registry
    )
    {
        $this->_orderFactory = $orderFactory;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultForwardFactory = $resultForwardFactory;
        $this->_registry = $registry;
        parent::__construct($context, $orderFactory);
    }

    public function execute()
    {
        if (($json = $this->getRequest()->getParam('json')) && $json == 1) {
            return parent::execute();
        }
        $orderId = $this->getRequest()->getParam('orderID');
        $order = $this->_orderFactory->create();
        $order->load($orderId);
        if (!$order->getId()) {
            $resultForward = $this->_resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        $this->_registry->register('order', $order);
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Order Info'));
        return $resultPage;
    }
}