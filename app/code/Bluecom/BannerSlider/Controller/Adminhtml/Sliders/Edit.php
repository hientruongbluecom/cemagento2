<?php
namespace Bluecom\BannerSlider\Controller\Adminhtml\Sliders;

use Bluecom\BannerSlider\Controller\Adminhtml\Sliders;

class Edit extends Sliders
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('slider_id');
        $model =  $this->_objectManager->create('Bluecom\BannerSlider\Model\Sliders');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This slider no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('bc_sliders', $model);

        $resultPage = $this->_resultPageFactory->create();

        return $resultPage;
    }
}