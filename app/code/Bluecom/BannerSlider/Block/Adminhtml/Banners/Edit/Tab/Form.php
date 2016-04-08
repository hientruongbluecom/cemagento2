<?php
namespace Bluecom\BannerSlider\Block\Adminhtml\Banners\Edit\Tab;

use Bluecom\BannerSlider\Model\SlidersFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
use Magento\Cms\Model\Wysiwyg\Config;

class Form extends Generic implements TabInterface
{
    protected  $_systemStore;

    protected $_wysiwygConfig;

    protected $_sliderFactory;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Store $systemStore,
        SlidersFactory $slidersFactory,
        array $data = []
    )
    {
        $this->_sliderFactory = $slidersFactory;
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context,$registry,$formFactory,$data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('bc_banners');

        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('item_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Item Information')]);

        if ($model->getId()) {
            $fieldset->addField('banner_id', 'hidden', ['name' => 'banner_id']);
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true,
                'class' => 'required-entry',
            ]
        );

        $fieldMaps['slider_id'] = $fieldset->addField(
            'slider_id',
            'select',
            [
                'label' => __('Slider'),
                'title' => __('Slider'),
                'name' => 'slider_id',
                'options' => $this->getOptionListSlider(),
                'disabled' => false,
            ]
        );

        $fieldMaps['status'] = $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Banner Status'),
                'title' => __('Banner Status'),
                'name' => 'status',
                'options' => $this->getOptionStatuses(),
                'disabled' => false,
            ]
        );

        $fieldMaps['url'] = $fieldset->addField(
            'url',
            'text',
            [
                'title' => __('URL'),
                'label' => __('URL'),
                'name' => 'url',
                'class' => 'validate-url',
            ]
        );

        $fieldMaps['image'] = $fieldset->addField(
            'image',
            'image',
            [
                'title' => __('Banner Image'),
                'label' => __('Banner Image'),
                'name' => 'image',
                'required' => true,
                'class'    => 'required-file',
                'disabled' => false,
                'note' => 'Allow image type: jpg, jpeg, gif, png',
            ]
        );

        $fieldMaps['image'] = $fieldset->addField(
            'image_alt',
            'text',
            [
                'title' => __('Image Alt For Seo'),
                'label' => __('Image Alt For Seo'),
                'name' => 'image_alt',
            ]
        );

        $fieldMaps['description'] = $fieldset->addField(
            'description',
            'editor',
            [
                'name' => 'description',
                'label' => __('Note\'s content'),
                'title' => __('Note\'s content'),
                'wysiwyg' => true,
                'required' => false,
            ]
        );

        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $timeFormat = $this->_localeDate->getTimeFormat(\IntlDateFormatter::SHORT);

        if($model->hasData('start_time')) {
            $datetime = new \DateTime($model->getData('start_time'));
            $model->setData('start_time', $datetime->setTimezone(new \DateTimeZone($this->_localeDate->getConfigTimezone())));
        }

        if($model->hasData('end_time')) {
            $datetime = new \DateTime($model->getData('end_time'));
            $model->setData('end_time', $datetime->setTimezone(new \DateTimeZone($this->_localeDate->getConfigTimezone())));
        }

        $fieldMaps['start_time'] = $fieldset->addField(
            'start_time',
            'date',
            [
                'name' => 'start_time',
                'label' => __('Start Date'),
                'date_format' => $dateFormat,
                'time_format' => $timeFormat,
                'title' => __('Start Date'),
                'required' => true,
                'class' => 'required-entry',
                'readonly' => true,
                'note' => $this->_localeDate->getDateTimeFormat(\IntlDateFormatter::SHORT),
            ]
        );

        $fieldMaps['end_time'] = $fieldset->addField(
            'end_time',
            'date',
            [
                'name' => 'end_time',
                'label' => __('End Date'),
                'date_format' => $dateFormat,
                'time_format' => $timeFormat,
                'title' => __('End Date'),
                'required' => true,
                'class' => 'required-entry',
                'readonly' => true,
                'note' => $this->_localeDate->getDateTimeFormat(\IntlDateFormatter::SHORT),
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
    * @return \Magento\Framework\Phrase
    */
    public function getTabLabel()
    {
        return __('Banner Information');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Banner Information');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Get options of Status banner
     *
     * @return array
     */
    protected function getOptionStatuses()
    {
        return [
            1 => __('Enabled'),
            2 => __('Disabled')
        ];
    }

    /**
     * Get options of list slider
     *
     * @return array
     */
    protected  function getOptionListSlider()
    {
        $option[''] = __('-------- Please select a slider --------');

        $modelSlider = $this->_sliderFactory->create();
        $sliderCollection = $modelSlider->getCollection();

        foreach ($sliderCollection as $slider) {
            $option[$slider->getId()] =$slider->getTitle();
        }

        return $option;
    }
}