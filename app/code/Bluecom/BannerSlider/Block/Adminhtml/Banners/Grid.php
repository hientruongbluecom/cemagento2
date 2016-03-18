<?php
namespace Bluecom\BannerSlider\Block\Adminhtml\Banners;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Module\Manager;

class Grid extends Extended
{
    /**
     * @var Banners
     */
    protected $_bannerFactory;
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
        \Bluecom\BannerSlider\Model\BannersFactory $bannerFactory,
        Manager $moduleManager,
        array $data = []
    ){
        $this->_bannerFactory = $bannerFactory;
        $this->_moduleManager = $moduleManager;
        parent::__construct($context,$helperBackend, $data);
    }

    /**
     *
     */
    protected function _construct(){
        parent::_construct();
        $this->setId('bannerGrid');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('banner_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_bannerFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'banner_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'banner_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'class' => 'xxx',
                'width' => '50px',
                'filter' => false,
                'renderer' => 'Bluecom\BannerSlider\Block\Adminhtml\Banners\Renderer\Image',
            ]
        );
        $this->addColumn(
            'url',
            [
                'header' => __('URL'),
                'index' => 'url',
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
                        'field' => 'banner_id',
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
        $this->getMassactionBlock()->setFormFieldName('banner');

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
            ['banner_id' => $row->getId()]
        );
    }
}