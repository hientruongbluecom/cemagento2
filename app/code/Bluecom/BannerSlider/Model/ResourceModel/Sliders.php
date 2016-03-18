<?php
namespace Bluecom\BannerSlider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Sliders extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('bc_slider', 'slider_id');
    }
}