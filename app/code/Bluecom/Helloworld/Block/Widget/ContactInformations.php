<?php
namespace Bluecom\Helloworld\Block\Widget;

class ContactInformations extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * Get block contact information
     */
    public function _toHtml()
    {
        $this->setTemplate('widget/contact_informations.phtml');
    }
}