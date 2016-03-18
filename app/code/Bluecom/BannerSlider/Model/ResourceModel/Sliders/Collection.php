<?php
namespace Bluecom\BannerSlider\Model\ResourceModel\Sliders;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Bluecom\BannerSlider\Model\Sliders', 'Bluecom\BannerSlider\Model\ResourceModel\Sliders');
    }
}