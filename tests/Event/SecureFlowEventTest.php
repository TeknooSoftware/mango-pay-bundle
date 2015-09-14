<?php

namespace UniAlteri\MangoPayBundle\Tests\Event;

use MangoPay\PayIn;
use Symfony\Component\HttpFoundation\Response;
use UniAlteri\MangoPayBundle\Entity\SecureFlowSession;
use UniAlteri\MangoPayBundle\Event\SecureFlowEvent;

/**
 * Class SecureFlowEventTest
 * @package UniAlteri\MangoPayBundle\Tests\Event
 * @covers UniAlteri\MangoPayBundle\Event\SecureFlowEvent
 */
class SecureFlowEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SecureFlowSession
     */
    protected $secureFlowSessionMock;

    /**
     * @var PayIn
     */
    protected $payInMock;

    /**
     * @var Response
     */
    protected $responseMock;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|SecureFlowSession
     */
    protected function getSecureFlowSessionMock()
    {
        if (!$this->secureFlowSessionMock instanceof SecureFlowSession) {
            $this->secureFlowSessionMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\SecureFlowSession', [], [], '', false);
        }

        return $this->secureFlowSessionMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PayIn
     */
    protected function getPayInMock()
    {
        if (!$this->payInMock instanceof PayIn) {
            $this->payInMock = $this->getMock('MangoPay\PayIn', [], [], '', false);
        }

        return $this->payInMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Response
     */
    protected function getResponseMock()
    {
        if (!$this->responseMock instanceof Response) {
            $this->responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response', [], [], '', false);
        }

        return $this->responseMock;
    }

    /**
     * @return SecureFlowEvent
     */
    public function buildService()
    {
        return new SecureFlowEvent(
            $this->getPayInMock(),
            $this->getResponseMock(),
            $this->getSecureFlowSessionMock()
        );
    }

    public function testGetResponse()
    {
        $this->assertEquals(
            $this->getResponseMock(),
            $this->buildService()->getResponse()
        );
    }

    public function testGetPayIn()
    {
        $this->assertEquals(
            $this->getPayInMock(),
            $this->buildService()->getPayIn()
        );
    }

    public function testGetSecureFlowSession()
    {
        $this->assertEquals(
            $this->getSecureFlowSessionMock(),
            $this->buildService()->getSecureFlowSession()
        );
    }
}