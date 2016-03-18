<?php
namespace Bluecom\BannerSlider\Controller\Adminhtml\Banners;

use Bluecom\BannerSlider\Controller\Adminhtml\Banners;

class Index extends Banners
{
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Banners Manage'));
        return $resultPage;
    }
}