<?php
namespace Bluecom\BannerSlider\Block\Adminhtml;

class Sliders extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor.
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_sliders';
        $this->_blockGroup = 'Bluecom_BannerSlider';
        $this->_headerText = __('Slider');
        $this->_addButtonLabel = __('Add New Slider');
        parent::_construct();
    }
}