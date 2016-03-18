<?php
namespace Bluecom\BannerSlider\Model\ResourceModel\Banners;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Bluecom\BannerSlider\Model\Banners', 'Bluecom\BannerSlider\Model\ResourceModel\Banners');
    }
}