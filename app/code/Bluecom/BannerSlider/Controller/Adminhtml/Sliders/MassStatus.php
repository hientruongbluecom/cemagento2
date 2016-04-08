<?php

namespace Bluecom\BannerSlider\Controller\Adminhtml\Sliders;

use Bluecom\BannerSlider\Controller\Adminhtml\Sliders;

class MassStatus extends Sliders
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $sliderIds = $this->getRequest()->getParam('slider');
        $status = $this->getRequest()->getParam('status');

        if (!is_array($sliderIds) || empty($sliderIds)) {
            $this->messageManager->addError(__('Please select banner(s).'));
        } else {
            $sliderCollection = $this->_sliderModel->getCollection()
                ->addFieldToFilter('slider_id', ['in' => $sliderIds]);
            try {
                foreach ($sliderCollection as $slider) {
                    $slider->setStatus($status)->save();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been changed status.', count($sliderIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
