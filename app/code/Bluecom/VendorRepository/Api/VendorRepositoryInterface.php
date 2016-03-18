<?php

namespace Bluecom\VendorRepository\Api;

interface VendorRepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function load($id);

    /**
     * @param \Bluecom\Vendor\Api\Data\VendorInterface $vendor
     * @return mixed
     */
    public function save(\Bluecom\Vendor\Api\Data\VendorInterface $vendor);

    /**
     * @param \Magento\Framework\Api\SortOrder $searchCriteria
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SortOrder $searchCriteria);

    /**
     * @param $id
     * @return mixed
     */
    public function getAssociatedProductIds($id);
}