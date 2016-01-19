<?php
namespace Bluecom\FreeGeoIp\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Logger\Monolog as Logger;
use Magento\Customer\Model\Session;

class getGeoIp implements ObserverInterface
{
    protected $_request;
    protected $_customerSession;
    protected $_logger;

    /**
     * Observer construct method
     *
     * @param Http $request
     * @param Session $session
     * @param Logger $logger
     */
    public function __construct(
        Http $request,
        Session $session,
        Logger $logger
    )
    {
        $this->_customerSession = $session;
        $this->_logger = $logger;
        $this->_request = $request;
    }

    /**
     * Get Country User
     *
     * @param EventObserver $observer
     */
    public function execute(EventObserver $observer)
    {
        if (!$this->_customerSession->getLocated()) {

            //$clientIP = $this->_request->getClientIp();
            /*
            * Set static Ip to test
            *
            * DE : 194.55.30.46
            * VN : 123.30.215.27
            * PL : 212.77.98.9
            * SG : 202.157.143.72
            *
            **/
            $clientIP = '123.30.215.27';
            $uri = 'http://freegeoip.net/json/' . $clientIP;

            $httpClient = new \Zend\Http\Client();
            $httpClient->setUri($uri);
            $httpClient->setOptions(array(
                'timeout' => 30
            ));

            try {
                $response = \Zend\Json\Decoder::decode($httpClient->send()->getBody());

                $this->_customerSession->setLocationData($response);
                $this->_customerSession->setLocated(true);
            } catch (\Exception $e) {
                $this->_logger->critical($e);
            }
        }
    }
}