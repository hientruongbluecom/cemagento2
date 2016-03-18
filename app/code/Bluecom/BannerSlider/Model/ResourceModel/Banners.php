<?php
namespace Bluecom\BannerSlider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Banners extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('bc_banner', 'banner_id');
    }
}