<?php
namespace Bluecom\BannerSlider\Model\Widget;

class Sliders extends \Bluecom\BannerSlider\Model\Sliders implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $items = $this->getCollection()->addFieldToFilter('status', array('eq' => '1'))->getData();
        foreach($items as $item){
            $options[] = ['value' => $item['slider_id'], 'label' => __($item['title'])];
        }
        return $options;

    }
}