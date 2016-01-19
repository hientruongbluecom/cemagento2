<?php
namespace Bluecom\OrderController\Controller\Infor;

use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\OrderFactory;
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_orderFactory;

    public function __construct(
        Context $context,
        OrderFactory $orderFactory
    )
    {
        $this->_orderFactory = $orderFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $orderId = $this->getRequest()->getParam('orderID');

        $order = $this->_orderFactory->create();
        $order->load($orderId);

        $orderData = [];

        if ($order->getId()) {
            $orderData['status'] = $order->getStatus();
            $orderData['total'] = $order->getGrandTotal();

            $items = [];
            foreach ($order->getAllVisibleItems() as $item) {
                $items[] = [
                    'sku' => $item->getSku(),
                    'item_id' => $item->getId(),
                    'price' => $item->getPriceInclTax()
                ];
            }
            $orderData['items'] = $items;

            $orderData['total_invoiced'] = $order->getTotalInvoiced();
        }

        $this->getResponse()->setBody(json_encode($orderData));
    }
}