<?php
namespace Bluecom\BannerSlider\Controller\Adminhtml\Banners;

use Bluecom\BannerSlider\Controller\Adminhtml\Banners;

class NewAction extends Banners
{
    public function execute(){
        $resultForward = $this->_resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}