<?php
namespace Bluecom\Helloworld\Model\Config\Source;

class Gender implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Create option to contact form
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 'mal', 'label' => __('Male')],
            ['value' => 'female', 'label' => __('Female')]];
    }
}