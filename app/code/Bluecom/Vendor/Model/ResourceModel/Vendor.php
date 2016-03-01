<?php
namespace Bluecom\Vendor\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Vendor extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('training4_vendor','vendor_id');
    }
    public function getAssignedProductIds($vendorId)
    {
        if (!$vendorId) {
            return [];
        }

        $connection = $this->getConnection();

        $select = $this->getConnection()->select()
            ->from($this->getTable('training4_vendor2product'), ['product_id'])
            ->where('vendor_id = ?', $vendorId);

        //echo $select->__toString();

        return $connection->fetchCol($select);
    }
}