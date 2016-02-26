<?php
namespace Bluecom\OrderInfo\Block;

class OrderInfo extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    public function getOrder()
    {
        return $this->_registry->registry('order');
    }
}
