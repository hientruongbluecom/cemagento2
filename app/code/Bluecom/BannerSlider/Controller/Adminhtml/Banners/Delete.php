<?php
namespace Bluecom\BannerSlider\Controller\Adminhtml\Banners;

use Bluecom\BannerSlider\Controller\Adminhtml\Banners;

class Delete extends Banners
{
    /**
     * Delete banner action
     *
     */
    public function execute(){

        $bannerId = $this->getRequest()->getParam('banner_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($bannerId) {
            try {
                $banner = $this->_bannerFactory->create()->setId($bannerId);
                $banner->delete();
                $this->messageManager->addSuccess(
                    __('Delete successfully!')
                );
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['banner_id' => $bannerId]);
            }
        }
        $this->messageManager->addSuccess(
            __('Item not found to delete!')
        );
        return $resultRedirect->setPath('*/*/');
    }
}