<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * CatalogWidget Rule Combine Condition data model
 */
namespace Bluecom\ProductSlider\Model\Rule\Condition;

class Combine extends \Magento\Rule\Model\Condition\Combine
{
    /**
     * @var \Bluecom\ProductSlider\Model\Rule\Condition\ProductFactory
     */
    protected $productFactory;

    /**
     * {@inheritdoc}
     */
    protected $elementName = 'parameters';

    /**
     * @param \Magento\Rule\Model\Condition\Context $context
     * @param \Bluecom\ProductSlider\Model\Rule\Condition\ProductFactory $conditionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Rule\Model\Condition\Context $context,
        \Bluecom\ProductSlider\Model\Rule\Condition\ProductFactory $conditionFactory,
        array $data = []
    ) {
        $this->productFactory = $conditionFactory;
        parent::__construct($context, $data);
        $this->setType('Bluecom\ProductSlider\Model\Rule\Condition\Combine');
    }

    /**
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        $productAttributes = $this->productFactory->create()->loadAttributeOptions()->getAttributeOption();
        $attributes = [];
        foreach ($productAttributes as $code => $label) {
            $attributes[] = [
                'value' => 'Bluecom\ProductSlider\Model\Rule\Condition\Product|' . $code,
                'label' => $label,
            ];
        }
        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive(
            $conditions,
            [
                [
                    'value' => 'Bluecom\ProductSlider\Model\Rule\Condition\Combine',
                    'label' => __('Conditions Combination'),
                ],
                ['label' => __('Product Attribute'), 'value' => $attributes]
            ]
        );
        return $conditions;
    }

    /**
     * Collect validated attributes for Product Collection
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
     * @return $this
     */
    public function collectValidatedAttributes($productCollection)
    {
        foreach ($this->getConditions() as $condition) {
            $condition->addToCollection($productCollection);
        }
        return $this;
    }
}
