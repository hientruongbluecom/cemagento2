<?php
namespace Bluecom\Warranty\Model\Product\Attribute\Frontend;

class Warranty extends \Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend
{
    public function getValue(\Magento\Framework\DataObject $object)
    {
        $value = parent::getValue($object);
        return sprintf('<strong>%s</strong>', $value);
    }

}
