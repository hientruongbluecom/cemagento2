<?php
namespace Bluecom\BannerSlider\Block\Adminhtml\Sliders;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Module\Manager;

class Grid extends Extended
{
    /**
     * @var Banners
     */
    protected $_sliderFactory;
    /**
     * @var
     */
    protected $_moduleManager;

    /**
     * @param Context $context
     * @param Data $helperBackend
     * @param Banners $bannerFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $helperBackend,
        \Bluecom\BannerSlider\Model\SlidersFactory $sliderFactory,
        Manager $moduleManager,
        array $data = []
    ){
        $this->_sliderFactory = $sliderFactory;
        $this->_moduleManager = $moduleManager;
        parent::__construct($context,$helperBackend, $data);
    }

    /**
     *
     */
    protected function _construct(){
        parent::_construct();
        $this->setId('sliderGrid');
        $this->setDefaultSort('slider_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('slider_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_sliderFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'slider_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'slider_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => $this->getOptionStatuses(),
            ]
        );

        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => ['base' => '*/*/edit'],
                        'field' => 'slider_id',
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );
        return parent::_prepareColumns();
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
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('slider');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('banneradmin/*/massDelete'),
                'confirm' => __('Are you sure?'),
            ]
        );

        $statuses = $this->getOptionStatuses();

        array_unshift($statuses, ['label' => '', 'value' => '']);
        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('banneradmin/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses,
                    ],
                ],
            ]
        );

        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('banneradmin/*/grid', ['_current' => true]);
    }

    public function getRowUrl($row)
    {
        return $this->getUrl(
            'banneradmin/*/edit',
            ['slider_id' => $row->getId()]
        );
    }
}