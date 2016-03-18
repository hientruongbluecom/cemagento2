<?php
namespace Bluecom\VendorRepository\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\DataObjectHelper;
use Bluecom\VendorRepository\Api\VendorRepositoryInterface;

class VendorRepository implements VendorRepositoryInterface
{
    protected $_vendorFactory;

    protected $_vendorCollectionFactory;

    protected $_resource;

    protected $_searchResultsFactory;

    protected $_dataVendorFactory;

    protected $_dataObjectHelper;

    protected $_dataObjectProcessor;

    public function __construct(
        \Bluecom\Vendor\Model\VendorFactory $vendorFactory,
        \Bluecom\Vendor\Model\ResourceModel\Vendor\CollectionFactory $vendorCollectionFactory,
        \Bluecom\Vendor\Model\ResourceModel\Vendor $resource,
        \Bluecom\Vendor\Api\Data\VendorSearchResultsInterfaceFactory $searchResultsFactory,
        \Bluecom\Vendor\Api\Data\VendorInterfaceFactory $dataVendorFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    )
    {
        $this->_vendorFactory = $vendorFactory;
        $this->_vendorCollectionFactory = $vendorCollectionFactory;
        $this->_resource = $resource;
        $this->_searchResultsFactory = $searchResultsFactory;
        $this->_dataVendorFactory = $dataVendorFactory;
        $this->_dataObjectHelper = $dataObjectHelper;
        $this->_dataObjectProcessor = $dataObjectProcessor;
    }

    public function load($id)
    {
        $vendor = $this->_vendorFactory->create();
        $this->_resource->load($vendor, $id);
        if (!$vendor->getId()) {
            throw new NoSuchEntityException(__('Vendor with id "%1" does not exist.', $id));
        }
        return $vendor;
    }

    public function save(\Bluecom\Vendor\Api\Data\VendorInterface $vendor)
    {
        try {
            $this->_resource->save($vendor);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $vendor;
    }

    public function getList(\Magento\Framework\Api\SortOrder $criteria)
    {
        $searchResults = $this->_searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->_vendorCollectionFactory->create();

        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $searchResults->setTotalCount($collection->getSize());

        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());

        $vendors = [];
        foreach ($collection as $vendorModel) {
            $vendorData = $this->_dataVendorFactory->create();
            $this->_dataObjectHelper->populateWithArray(
                $vendorData,
                $vendorModel->getData(),
                'Bluecom\Vendor\Api\Data\VendorInterface'
            );
            $vendors[] = $this->_dataObjectProcessor->buildOutputDataArray(
                $vendorData,
                'Bluecom\Vendor\Api\Data\VendorInterface'
            );
        }
        $searchResults->setItems($vendors);

        return $searchResults;
    }

    public function getAssociatedProductIds($id)
    {
        $vendor = $this->load($id);
        return $vendor->getAssignedProductIds();
    }
}