<?php
namespace Bluecom\BannerSlider\Controller\Adminhtml;

abstract class Sliders extends BannerAbstract
{
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bluecom_BannerSlider::sliders');
    }
}