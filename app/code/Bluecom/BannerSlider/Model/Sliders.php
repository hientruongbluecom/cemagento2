<?php
namespace Bluecom\BannerSlider\Model;

use Magento\Framework\Model\AbstractModel;

class Sliders extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Bluecom\BannerSlider\Model\ResourceModel\Sliders');
    }
}