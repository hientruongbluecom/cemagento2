<?php
namespace Bluecom\BannerSlider\Block\Sliders\Edit\Tab;

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

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Store $systemStore,
        array $data = []
    )
    {
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context,$registry,$formFactory,$data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('bc_sliders');

        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('item_');      $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Item Information')]);

        if ($model->getId()) {
            $fieldset->addField('slider_id', 'hidden', ['name' => 'slider_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
                'class' => 'required-entry',
            ]
        );

        $fieldMaps['show_title'] = $fieldset->addField(
            'show_title',
            'select',
            [
                'label' => __('Show Title'),
                'title' => __('Show Title'),
                'name' => 'show_title',
                'options' => $this->getOptionStatuses(),
                'disabled' => false,
            ]
        );

        $fieldMaps['status'] = $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Slider Status'),
                'title' => __('Slider Status'),
                'name' => 'status',
                'options' => $this->getOptionStatuses(),
                'disabled' => false,
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

        if (!$model->getId()) {
            $model->setData('status', '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
    * @return \Magento\Framework\Phrase
    */
    public function getTabLabel()
    {
        return __('Slider Information');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Slider Information');
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
}