<?php
namespace Bluecom\VendorRepository\Test\Unit\Model;

use Bluecom\VendorRepository\Model\VendorRepository;
use Magento\Framework\Api\SortOrder;

class VendorRepositoryTest extends \PHPUnit_Framework_TestCase
{
    protected $repository;

    protected $vendorResource;


    protected $vendor;


    protected $vendorData;


    protected $vendorSearchResult;


    protected $dataHelper;


    protected $dataObjectProcessor;


    protected $collection;

    public function setUp()
    {
        $this->vendorResource = $this->getMockBuilder('Bluecom\Vendor\Model\ResourceModel\Vendor')
            ->disableOriginalConstructor()
            ->getMock();
        $this->dataObjectProcessor = $this->getMockBuilder('Magento\Framework\Reflection\DataObjectProcessor')
            ->disableOriginalConstructor()
            ->getMock();
        $vendorFactory = $this->getMockBuilder('Bluecom\Vendor\Model\VendorFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $vendorDataFactory = $this->getMockBuilder('Bluecom\Vendor\Api\Data\VendorInterfaceFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $vendorSearchResultFactory = $this->getMockBuilder('Bluecom\Vendor\Api\Data\VendorSearchResultsInterfaceFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $collectionFactory = $this->getMockBuilder('Bluecom\Vendor\Model\ResourceModel\Vendor\CollectionFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->vendor = $this->getMockBuilder('Bluecom\Vendor\Model\Vendor')->disableOriginalConstructor()->getMock();
        $this->vendorData = $this->getMockBuilder('Bluecom\Vendor\Api\Data\VendorInterface')
            ->getMock();
        $this->vendorSearchResult = $this->getMockBuilder('Bluecom\Vendor\Api\Data\VendorSearchResultsInterface')
            ->getMock();
        $this->collection = $this->getMockBuilder('Bluecom\Vendor\Model\ResourceModel\Vendor\Collection')
            ->disableOriginalConstructor()
            ->setMethods(['addFieldToFilter', 'getSize', 'setCurPage', 'setPageSize', 'load', 'addOrder'])
            ->getMock();

        $vendorFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->vendor);
        $vendorDataFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->vendorData);
        $vendorSearchResultFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->vendorSearchResult);
        $collectionFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->collection);

        $this->dataHelper = $this->getMockBuilder('Magento\Framework\Api\DataObjectHelper')
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = new VendorRepository(
            $vendorFactory,
            $collectionFactory,
            $this->vendorResource,
            $vendorSearchResultFactory,
            $vendorDataFactory,
            $this->dataHelper,
            $this->dataObjectProcessor
        );
    }

    public function testGetList()
    {
        $field = 'name';
        $value = 'Vendor%';
        $condition = 'like';
        $total = 10;
        $currentPage = 1;
        $pageSize = 10;
        $sortField = 'vendor_id';

        $criteria = $this->getMockBuilder('Magento\Framework\Api\SearchCriteriaInterface')->getMock();
        $filterGroup = $this->getMockBuilder('Magento\Framework\Api\Search\FilterGroup')->getMock();
        $filter = $this->getMockBuilder('Magento\Framework\Api\Filter')->getMock();
        $sortOrder = $this->getMockBuilder('Magento\Framework\Api\SortOrder')->getMock();

        $criteria->expects($this->once())->method('getFilterGroups')->willReturn([$filterGroup]);
        $criteria->expects($this->once())->method('getSortOrders')->willReturn([$sortOrder]);
        $criteria->expects($this->once())->method('getCurrentPage')->willReturn($currentPage);
        $criteria->expects($this->once())->method('getPageSize')->willReturn($pageSize);
        $filterGroup->expects($this->once())->method('getFilters')->willReturn([$filter]);
        $filter->expects($this->once())->method('getConditionType')->willReturn($condition);
        $filter->expects($this->any())->method('getField')->willReturn($field);
        $filter->expects($this->once())->method('getValue')->willReturn($value);
        $sortOrder->expects($this->once())->method('getField')->willReturn($sortField);
        $sortOrder->expects($this->once())->method('getDirection')->willReturn(SortOrder::SORT_DESC);

        /** @var \Magento\Framework\Api\SearchCriteriaInterface $criteria */

        $this->collection->addItem($this->vendor);
        $this->vendorSearchResult->expects($this->once())
            ->method('setSearchCriteria')
            ->with($criteria)
            ->willReturnSelf();
        $this->collection->expects($this->once())
            ->method('addFieldToFilter')
            ->with($field, [$condition => $value])
            ->willReturnSelf();
        $this->vendorSearchResult->expects($this->once())->method('setTotalCount')->with($total)->willReturnSelf();
        $this->collection->expects($this->once())->method('getSize')->willReturn($total);
        $this->collection->expects($this->once())->method('setCurPage')->with($currentPage)->willReturnSelf();
        $this->collection->expects($this->once())->method('setPageSize')->with($pageSize)->willReturnSelf();
        $this->collection->expects($this->once())->method('addOrder')->with($sortField, 'DESC')->willReturnSelf();
        $this->vendor->expects($this->once())->method('getData')->willReturn(['data']);
        $this->vendorSearchResult->expects($this->once())->method('setItems')->with(['someData'])->willReturnSelf();
        $this->dataHelper->expects($this->once())
            ->method('populateWithArray')
            ->with($this->vendorData, ['data'], 'Bluecom\Vendor\Api\Data\VendorInterface');
        $this->dataObjectProcessor->expects($this->once())
            ->method('buildOutputDataArray')
            ->with($this->vendorData, 'Bluecom\Vendor\Api\Data\VendorInterface')
            ->willReturn('someData');

        $this->assertEquals($this->vendorSearchResult, $this->repository->getList($criteria));
    }
}