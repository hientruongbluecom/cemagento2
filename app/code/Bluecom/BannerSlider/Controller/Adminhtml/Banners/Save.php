<?php
namespace Bluecom\BannerSlider\Controller\Adminhtml\Banners;

use Magento\Framework\App\Filesystem\DirectoryList;

use Bluecom\BannerSlider\Controller\Adminhtml\Banners;

class Save extends Banners
{
    /**
     * Save banner action
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute(){
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (isset($data)) {
            $bannerId = $this->getRequest()->getParam('banner_id');;

            $model = $this->_bannerFactory->create();
            if ($bannerId) {
                $model->load($bannerId);
            }

            // save upload image banner
            if (isset($_FILES['image']) && isset($_FILES['image']['name']) && strlen($_FILES['image']['name'])) {
                try {
                    $uploader = $this->_objectManager->create('\Magento\MediaStorage\Model\File\Uploader', array('fileId' => 'image'));
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);

                    /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
                    $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                        ->getDirectoryRead(DirectoryList::MEDIA);
                    $result = $uploader->save(
                        $mediaDirectory->getAbsolutePath('bluecom/bannerslider/images'));

                    unset($result['tmp_name']);
                    unset($result['path']);

                    $data['image'] = 'bluecom/bannerslider/images'.$result['file'];

                } catch (\Exception $e) {
                    if ($e->getCode() == 0) {
                        $this->messageManager->addError($e->getMessage());
                    }
                }
            } else {

                if (isset($data['image']) && isset($data['image']['value'])) {
                    if (isset($data['image']['delete'])) {
                        $data['image'] = null;
                        $data['delete_image'] = true;
                    } elseif (isset($data['image']['value'])) {
                        $data['image'] = $data['image']['value'];
                    } else {
                        $data['image'] = null;
                    }
                }
            }
            // end save upload image banner

            $model->setData($data);

            try {
                $model->save();

                $this->messageManager->addSuccess(__('The banner has been saved.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['banner_id' => $model->getId(), '_current' => true]);
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
            return $resultRedirect->setPath('*/*/edit', ['banner_id' => $bannerId]);

        }

        return $resultRedirect->setPath('*/*/');
    }
}