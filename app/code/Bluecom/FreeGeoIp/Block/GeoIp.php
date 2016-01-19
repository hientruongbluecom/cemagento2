<?php
namespace Bluecom\FreeGeoIp\Block;

class GeoIp extends \Magento\Framework\View\Element\AbstractBlock
{
    protected $_customerSession;

    /**
     * Construct block FreeGeo Ip
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Customer\Model\Session $session
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Customer\Model\Session $session,
        array $data = []
    )
    {
        $this->_customerSession = $session;
        $this->_isScopePrivate = true;
        parent::__construct($context, $data);
    }

    /**
     * Get information country
     *
     * @return string
     */
    protected function _toHtml()
    {
        $locationData = $this->_customerSession->getLocationData();
        if(is_object($locationData)) {
            return sprintf('<div style="display: inline-block; padding-right: 50px;"><span>Country: </span>%s</div>', $locationData->country_name ? $locationData->country_name : 'No Country');
        }
    }
}