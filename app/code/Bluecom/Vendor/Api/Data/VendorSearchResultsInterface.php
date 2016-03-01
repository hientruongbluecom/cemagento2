<?php
namespace Bluecom\Vendor\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface VendorSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Bluecom\Vendor\Api\Data\VendorInterface[]
     */
    public function getItems();

    /**
     * @param \Bluecom\Vendor\Api\Data\VendorInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}