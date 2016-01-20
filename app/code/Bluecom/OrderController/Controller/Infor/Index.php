<?php
namespace Bluecom\OrderController\Controller\Infor;

use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\OrderFactory;
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_orderFactory;

    /**
     * Construct
     *
     * @param Context $context
     * @param OrderFactory $orderFactory
     */
    public function __construct(
        Context $context,
        OrderFactory $orderFactory
    )
    {
        $this->_orderFactory = $orderFactory;
        parent::__construct($context);
    }

    /**
     * Get Data Order 
     *
     * @throws \Exception
     * @throws \Zend_Validate_Exception
     */
    public function execute()
    {
        $orderId = $this->getRequest()->getParam('orderID');
        //check orderId is number
        if (\Zend_Validate::is($orderId, 'Regex', array('pattern' => '/^\s*-?\d*(\.\d*)?\s*$/'))) {
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

            if (empty($orderData))
            {
                $this->getResponse()->setBody('Order not found!');
            } else {
                $this->getResponse()->setBody(json_encode($orderData));
            }
        } else {
            $this->getResponse()->setBody('Error! OrderID must only is number!');
        }
    }
}