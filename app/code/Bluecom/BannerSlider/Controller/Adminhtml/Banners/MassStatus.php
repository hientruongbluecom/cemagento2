<?php

namespace Bluecom\BannerSlider\Controller\Adminhtml\Banners;

use Bluecom\BannerSlider\Controller\Adminhtml\Banners;

class MassStatus extends Banners
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $bannerIds = $this->getRequest()->getParam('banner');
        $status = $this->getRequest()->getParam('status');

        if (!is_array($bannerIds) || empty($bannerIds)) {
            $this->messageManager->addError(__('Please select banner(s).'));
        } else {
            $bannerCollection = $this->_bannerModel->getCollection()
                ->addFieldToFilter('banner_id', ['in' => $bannerIds]);
            try {
                foreach ($bannerCollection as $banner) {
                    $banner->setStatus($status)->save();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been changed status.', count($bannerIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
