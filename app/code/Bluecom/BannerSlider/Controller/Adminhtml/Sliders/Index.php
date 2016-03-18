<?php
namespace Bluecom\BannerSlider\Controller\Adminhtml\Sliders;

use Bluecom\BannerSlider\Controller\Adminhtml\Sliders;

class Index extends Sliders
{
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Sliders Manage'));
        return $resultPage;
    }
}