<?php
namespace Bluecom\BannerSlider\Controller\Adminhtml\Banners;

use Bluecom\BannerSlider\Controller\Adminhtml\Banners;

class Edit extends Banners
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('banner_id');
        $model =  $this->_objectManager->create('Bluecom\BannerSlider\Model\Banners');

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

        $this->_coreRegistry->register('bc_banners', $model);

        $resultPage = $this->_resultPageFactory->create();

        return $resultPage;
    }
}