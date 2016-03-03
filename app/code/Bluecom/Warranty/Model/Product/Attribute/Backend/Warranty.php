<?php
namespace Bluecom\Warranty\Model\Product\Attribute\Backend;

class Warranty extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    public function beforeSave($object)
    {
        $attrCode = $this->getAttribute()->getAttributeCode();
        if ($object->hasData($attrCode) && preg_match('%^([\d]*)[\sa-z]*?$%', $object->getData($attrCode), $m)) {
            $object->setData($attrCode, sprintf('%s year%s', $m[1], $m[1] > 1 ? 's' : ''));
        }
        return $this;
    }

}
