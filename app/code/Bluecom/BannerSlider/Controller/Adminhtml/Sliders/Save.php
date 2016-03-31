<?php
namespace Bluecom\BannerSlider\Controller\Adminhtml\Sliders;

use Bluecom\BannerSlider\Controller\Adminhtml\Sliders;

class Save extends Sliders
{
    /**
     * Save slider action
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute(){
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (isset($data)) {
            $sliderId = $this->getRequest()->getParam('slider_id');;

            $model = $this->_sliderFactory->create();

            $model->load($sliderId);

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('The slider has been saved.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['slider_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the item.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['slider_id' => $sliderId]);

        }

        return $resultRedirect->setPath('*/*/');
    }
}