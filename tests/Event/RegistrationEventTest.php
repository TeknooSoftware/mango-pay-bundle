<?php

namespace UniAlteri\MangoPayBundle\Tests\Event;

use MangoPay\CardRegistration;
use Symfony\Component\HttpFoundation\Response;
use UniAlteri\MangoPayBundle\Entity\CardRegistrationSession;
use UniAlteri\MangoPayBundle\Event\RegistrationEvent;

/**
 * Class RegistrationEventTest
 * @package UniAlteri\MangoPayBundle\Tests\Event
 * @covers UniAlteri\MangoPayBundle\Event\RegistrationEvent
 */
class RegistrationEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CardRegistrationSession
     */
    protected $registrationSessionMock;

    /**
     * @var CardRegistration
     */
    protected $cardRegistrationMock;

    /**
     * @var Response
     */
    protected $responseMock;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|CardRegistrationSession
     */
    protected function getCardRegistrationSessionMock()
    {
        if (!$this->registrationSessionMock instanceof CardRegistrationSession) {
            $this->registrationSessionMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\CardRegistrationSession', [], [], '', false);
        }

        return $this->registrationSessionMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|CardRegistration
     */
    protected function getCardRegistrationMock()
    {
        if (!$this->cardRegistrationMock instanceof CardRegistration) {
            $this->cardRegistrationMock = $this->getMock('MangoPay\CardRegistration', [], [], '', false);
        }

        return $this->cardRegistrationMock;
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
     * @return RegistrationEvent
     */
    public function buildService()
    {
        return new RegistrationEvent(
            $this->getCardRegistrationSessionMock(),
            $this->getCardRegistrationMock(),
            $this->getResponseMock()
        );
    }

    public function testGetResponse()
    {
        $this->assertEquals(
            $this->getResponseMock(),
            $this->buildService()->getResponse()
        );
    }

    public function testGetRegistrationSession()
    {
        $this->assertEquals(
            $this->getCardRegistrationSessionMock(),
            $this->buildService()->getRegistrationSession()
        );
    }

    public function testGetCardRegistration()
    {
        $this->assertEquals(
            $this->getCardRegistrationMock(),
            $this->buildService()->getCardRegistration()
        );
    }
}