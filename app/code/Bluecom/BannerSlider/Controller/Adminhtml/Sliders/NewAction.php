<?php
namespace Bluecom\BannerSlider\Controller\Adminhtml\Sliders;

use Bluecom\BannerSlider\Controller\Adminhtml\Sliders;

class NewAction extends Sliders
{
    public function execute(){
        $resultForward = $this->_resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}