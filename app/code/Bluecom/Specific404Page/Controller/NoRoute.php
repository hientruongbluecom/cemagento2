<?php
namespace Bluecom\Specific404Page\Controller;

class NoRoute extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultLayout = $this->resultPageFactory->create();
        $resultLayout->setStatusHeader(404, '1.1', 'Not Found');
        $resultLayout->setHeader('Status', '404 File not found');
        return $resultLayout;
    }
}