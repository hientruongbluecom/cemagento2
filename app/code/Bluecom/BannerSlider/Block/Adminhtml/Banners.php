<?php
namespace Bluecom\BannerSlider\Block\Adminhtml;

class Banners extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor.
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_banners';
        $this->_blockGroup = 'Bluecom_BannerSlider';
        $this->_headerText = __('Banner');
        $this->_addButtonLabel = __('Add New Banner');
        parent::_construct();
    }
}