<?php
namespace Bluecom\BannerSlider\Controller\Adminhtml\Sliders;

use Bluecom\BannerSlider\Controller\Adminhtml\Sliders;

class Delete extends Sliders
{
    /**
     * Delete slider action
     *
     */
    public function execute(){

        $sliderId = $this->getRequest()->getParam('slider_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($sliderId) {
            try {
                $slider = $this->_sliderFactory->create()->setId($sliderId);
                $slider->delete();
                $this->messageManager->addSuccess(
                    __('Delete successfully!')
                );
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['slider_id' => $sliderId]);
            }
        }
        $this->messageManager->addSuccess(
            __('Item not found to delete!')
        );
        return $resultRedirect->setPath('*/*/');
    }
}