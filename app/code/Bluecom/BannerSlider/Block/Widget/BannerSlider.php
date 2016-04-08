<?php
namespace Bluecom\BannerSlider\Block\Widget;

use Bluecom\BannerSlider\Model\Banners;
use Magento\Framework\Stdlib\DateTime\Timezone;
use Magento\Framework\View\Element\Template\Context;

class BannerSlider extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    const SLIDER_ID = 0;
    /**
     * @var \Bluecom\BannerSlider\Model\BannersFactory
     */
    protected $_bannerModel;

    /**
     * Template list banner slider
     * @var string
     */
    protected $_template = 'Bluecom_BannerSlider::slider/bannerslider.phtml';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * stdlib timezone.
     *
     * @var \Magento\Framework\Stdlib\DateTime\Timezone
     */
    protected $_stdTimezone;

    /**
     * Default value show navigation for paging control of each slide
     */
    const SHOW_NAVIGATION = false;

    /**
     * Default slide show speed
     */
    const SLIDE_SHOW_SPEED = 6000;

    /**
     * Default value show description of each banner
     */
    const SHOW_DESCRIPTION = false;
    /**
     * [__construct description].
     *
     * @param Context $context
     * @param Banners $bannersModel
     * @param array $data
     */
    public function __construct(
        Context $context,
        Banners $bannersModel,
        Timezone $stdTimezone,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->_bannerModel = $bannersModel;
        $this->_stdTimezone = $stdTimezone;
    }

    /**
     * Render block HTML
     * @return string
     */
    protected function _toHtml()
    {
        return parent::_toHtml();
    }

    /**
     * Get List Banner
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     */
    public function getCollectionBanners()
    {
        $sliderId = $this->getSliderId();
        $bannerCollection = $this->_bannerModel->getCollection();
        $bannerCollection->addFieldToFilter('slider_id',  array('eq' => $sliderId))
            ->addFieldToFilter('status', array('eq' => 1))
            ->setOrder('banner_id', 'ASC');
        return $bannerCollection;

    }

    /**
     * Get Slider Id
     * @return mixed|int
     */
    public function getSliderId()
    {
        if (null === $this->getData('slider_id')) {
            $this->setData('slider_id', self::SLIDER_ID);
        }
        return $this->getData('slider_id');
    }

    /**
     * Get Title Slider
     * @return mixed|string
     */
    public function getTitle()
    {
        return $this->getData('title');
    }

    /**
     * Get value of widgets' show navigation for paging control of each slide
     *
     * @return mixed|bool
     */
    public function getShowControlNav()
    {
        if (null === $this->getData('show_control_nav')) {
            $this->setData('show_control_nav', self::SHOW_NAVIGATION);
        }
        return $this->getData('show_control_nav');
    }

    /**
     * Get link image banner
     * @param string $imgName
     * @return string
     */
    public function getBannerImageUrl($imgName ='')
    {
        if ($imgName != '') {
            return $this->getUrl('pub/media/', ['_secure' => $this->getRequest()->isSecure()]) . $imgName;
        } else {
            /**
             * Get default image
             */
            return '';
        }
    }

    public function getSlideShowSpeed()
    {
        if (null === $this->getData('slide_show_speed')) {
            $this->setData('slide_show_speed', self::SLIDE_SHOW_SPEED);
        }
        return $this->getData('slide_show_speed');
    }

    public function getShowDescriptionBanner()
    {
        if (null === $this->getData('show_description_banner')) {
            $this->setData('show_description_banner', self::SHOW_DESCRIPTION);
        }
        return $this->getData('show_description_banner');
    }
}