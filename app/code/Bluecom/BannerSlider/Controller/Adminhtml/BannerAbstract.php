<?php
namespace Bluecom\BannerSlider\Controller\Adminhtml;

use Bluecom\BannerSlider\Model\Banners;
use Bluecom\BannerSlider\Model\BannersFactory;
use Bluecom\BannerSlider\Model\Sliders;
use Bluecom\BannerSlider\Model\SlidersFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\LayoutFactory;

abstract class BannerAbstract extends Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Result page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var
     */
    protected $_resultForwardFactory;

    protected $_resultLayoutFactory;

    protected $_bannerFactory;

    protected $_sliderFactory;

    protected $_bannerModel;

    protected $_sliderModel;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        LayoutFactory $resultLayoutFactory,
        ForwardFactory $forwardFactory,
        BannersFactory $bannersFactory,
        SlidersFactory $slidersFactory,
        Banners $bannerModel,
        Sliders $slidersModel
    )
    {
        $this->_coreRegistry = $coreRegistry;

        parent::__construct($context);

        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultForwardFactory = $forwardFactory;
        $this->_resultLayoutFactory = $resultLayoutFactory;

        $this->_bannerFactory = $bannersFactory;
        $this->_sliderFactory = $slidersFactory;
        $this->_bannerModel = $bannerModel;
        $this->_sliderModel = $slidersModel;
    }
}