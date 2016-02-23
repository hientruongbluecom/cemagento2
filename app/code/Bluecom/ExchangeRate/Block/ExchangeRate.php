<?php
namespace Bluecom\ExchangeRate\Block;

class ExchangeRate extends \Magento\Framework\View\Element\AbstractBlock
{
    const SOURCE_URL = 'http://api.fixer.io/latest?base=USD';

    protected $_clientFactory;
    protected $_logger;

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\HTTP\ZendClientFactory $clientFactory,
        \Psr\Log\LoggerInterface $logger,
        array $data = []
    )
    {
        $this->_isScopePrivate = true;
        $this->_clientFactory = $clientFactory;
        $this->_logger = $logger;
        parent::__construct($context, $data);
    }


    protected function _toHtml()
    {

        $client = $this->_clientFactory->create(['uri' => self::SOURCE_URL]);

        try {
            $result = $client->request();

            $rates = json_decode($result->getBody(), true);

            if (isset($rates['rates']['EUR'])) {
                return sprintf('<div style="display: inline-block;">1 USD = %s EUR | </div>', $rates['rates']['EUR']);
            }
        } catch (\Exception $e) {
            $this->_logger->critical($e);
        }
    }
}