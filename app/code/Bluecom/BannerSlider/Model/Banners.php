<?php
namespace Bluecom\BannerSlider\Model;

use Magento\Framework\Model\AbstractModel;

class Banners extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Bluecom\BannerSlider\Model\ResourceModel\Banners');
    }
}