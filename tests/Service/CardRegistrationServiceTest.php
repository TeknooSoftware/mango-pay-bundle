<?php

namespace UniAlteri\MangoPayBundle\Tests\Service;

use MangoPay\ApiCardRegistrations;
use MangoPay\CardRegistration;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UniAlteri\MangoPayBundle\Entity\CardRegistrationResult;
use UniAlteri\MangoPayBundle\Event\MangoPayEvents;
use UniAlteri\MangoPayBundle\Event\RegistrationEvent;
use UniAlteri\MangoPayBundle\Service\CardRegistrationService;
use UniAlteri\MangoPayBundle\Service\Interfaces\StorageServiceInterface;

/**
 * Class MangoApiServiceTest
 * @package UniAlteri\MangoPayBundle\Tests\Service
 * @covers UniAlteri\MangoPayBundle\Service\CardRegistrationService
 */
class CardRegistrationServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiCardRegistrations
     */
    protected $mangoApiCardRegistrationMock;

    /**
     * @var Router
     */
    protected $routerMock;

    /**
     * @var StorageServiceInterface
     */
    protected $storageServiceMock;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatchedMock;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Router
     */
    protected function getRouterMock()
    {
        if (!$this->routerMock instanceof Router) {
            $this->routerMock = $this->getMock('Symfony\Bundle\FrameworkBundle\Routing\Router', [], [], '', false);
        }

        return $this->routerMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EventDispatcherInterface
     */
    protected function getEventDispatcherInterfaceMock()
    {
        if (!$this->eventDispatchedMock instanceof EventDispatcherInterface) {
            $this->eventDispatchedMock = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface', [], [], '', false);
        }

        return $this->eventDispatchedMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ApiCardRegistrations
     */
    protected function getApiCardRegistrationsMock()
    {
        if (!$this->mangoApiCardRegistrationMock instanceof ApiCardRegistrations) {
            $this->mangoApiCardRegistrationMock = $this->getMock('MangoPay\ApiCardRegistrations', [], [], '', false);
        }

        return $this->mangoApiCardRegistrationMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|StorageServiceInterface
     */
    protected function getStorageServiceInterfaceMock()
    {
        if (!$this->storageServiceMock instanceof StorageServiceInterface) {
            $this->storageServiceMock = $this->getMock('UniAlteri\MangoPayBundle\Service\Interfaces\StorageServiceInterface', [], [], '', false);
        }

        return $this->storageServiceMock;
    }

    /**
     * @param string $routerName
     * @return CardRegistrationService
     */
    public function buildService($routerName)
    {
        return new CardRegistrationService(
            $this->getApiCardRegistrationsMock(),
            $this->getRouterMock(),
            $routerName,
            $this->getStorageServiceInterfaceMock(),
            $this->getEventDispatcherInterfaceMock()
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetRegistrationSessionFromIdExceptionOnNotFound()
    {
        $this->getStorageServiceInterfaceMock()->expects($this->once())->method('has')->with('MANGO_CARD_REGISTRATION1234')->willReturn(false);
        $this->buildService('routerValueName')->getRegistrationSessionFromId(1234);
    }

    public function testGetRegistrationSessionFromIdExceptionOnFound()
    {
        $cardRegistrationSessionMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\CardRegistrationSession', [], [], '', false);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('has')
            ->with('MANGO_CARD_REGISTRATION1234')
            ->willReturn(true);


        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('get')
            ->with('MANGO_CARD_REGISTRATION1234')
            ->willReturn($cardRegistrationSessionMock);

        $this->assertEquals(
            $cardRegistrationSessionMock,
            $this->buildService('routerValueName')->getRegistrationSessionFromId(1234)
        );
    }

    /**
     * @expectedException \UniAlteri\MangoPayBundle\Exception\BadMangoReturnException
     */
    public function testGetCardRegistrationFromMangoExceptionOnNotFound()
    {
        $this->getApiCardRegistrationsMock()->expects($this->once())->method('Get')->with(1234)->willReturn(null);
        $this->buildService('routerValueName')->getCardRegistrationFromMango(1234);
    }

    public function testGetCardRegistrationFromMangoFound()
    {
        $cardRegistrationMock = $this->getMock('MangoPay\CardRegistration');
        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Get')
            ->with(1234)
            ->willReturn($cardRegistrationMock);


        $this->assertEquals(
            $cardRegistrationMock,
            $this->buildService('routerValueName')->getCardRegistrationFromMango(1234)
        );
    }

    /**
     * @expectedException \UniAlteri\MangoPayBundle\Exception\BadMangoEntityException
     */
    public function testPrepareExceptionOnUserHasNotMangoPayId()
    {
        $userMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\UserInterface');
        $userMock->expects($this->once())->method('getMangoPayId')->willReturn(null);

        $cardSessionMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\CardRegistrationSession', [], [], '', false);

        $this->buildService('routerValueName')->prepare($userMock, $cardSessionMock);
    }

    public function testPrepare()
    {
        $userMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\UserInterface');
        $userMock->expects($this->atLeastOnce())->method('getMangoPayId')->willReturn(9876);

        /**
         * @var CardRegistration $cardRegistrationMock
         */
        $cardRegistrationMock = $this->getMock('MangoPay\CardRegistration');
        $cardRegistrationMock->Id = 1234;
        $cardRegistrationMock->Currency = 'EUR';
        $cardRegistrationMock->CardType = 'CB_VISA_MASTERCARD';
        $cardRegistrationMock->UserId = 9876;
        $cardRegistrationMock->AccessKey = 'abcdef';
        $cardRegistrationMock->PreregistrationData = 'stuvxyz';
        $cardRegistrationMock->CardRegistrationURL = 'https://foo.bar.com/return.php';

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Create')
            ->with(
                $this->callback(function ($card) {
                    $this->assertInstanceOf('MangoPay\CardRegistration', $card);
                    $this->assertEquals('EUR', $card->Currency);
                    $this->assertEquals('CB_VISA_MASTERCARD', $card->CardType);
                    $this->assertEquals(9876, $card->UserId);

                    return true;
                })
            )
            ->willReturn($cardRegistrationMock);

        $cardSessionMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\CardRegistrationSession', [], [], '', false);
        $cardSessionMock
            ->expects($this->once())
            ->method('setCardRegistrationId')
            ->with(1234)
            ->willReturnSelf();

        $cardSessionMock
            ->expects($this->once())
            ->method('setUser')
            ->with($userMock)
            ->willReturnSelf();

        $cardSessionMock
            ->expects($this->once())
            ->method('getSessionId')
            ->willReturn('fooBarId');

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('set')
            ->with('MANGO_CARD_REGISTRATIONfooBarId', $cardSessionMock)
            ->willReturnSelf();

        $this->getRouterMock()
            ->expects($this->once())
            ->method('generate')
            ->with('routerNameValue', ['registrationSessionId' => 'fooBarId'], Router::ABSOLUTE_URL)
            ->willReturn('http://foo.bar.com/return');

        $result = new CardRegistrationResult($userMock);
        $result->setAccessKeyRef('abcdef');
        $result->setData('stuvxyz');
        $result->setCardRegistrationUrl('https://foo.bar.com/return.php');
        $result->setId(1234);
        $result->setReturnUrl('http://foo.bar.com/return');

        $this->assertEquals($result, $this->buildService('routerNameValue')->prepare($userMock, $cardSessionMock));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testProcessMangoPayValidReturnExceptionOnSessionNotFound()
    {
        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('has')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn(false);

        $this->getApiCardRegistrationsMock()
            ->expects($this->never())
            ->method('Get');

        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $this->buildService('routerNameValue')->processMangoPayValidReturn('abcdef', 'value', $responseMock);
    }

    /**
     * @expectedException \UniAlteri\MangoPayBundle\Exception\BadMangoReturnException
     */
    public function testProcessMangoPayValidReturnMangoExceptionOnErrorNotFound()
    {
        $cardSessionMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\CardRegistrationSession', [], [], '', false);
        $cardSessionMock->expects($this->once())
            ->method('getCardRegistrationId')
            ->willReturn(1234);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('has')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn(true);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('get')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn($cardSessionMock);

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Get')
            ->with(1234)
            ->willReturn(null);

        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $this->buildService('routerNameValue')->processMangoPayValidReturn('abcdef', 'value', $responseMock);
    }

    public function testProcessMangoPayValidReturnMangoExceptionValidating()
    {
        $cardSessionMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\CardRegistrationSession', [], [], '', false);
        $cardSessionMock->expects($this->once())
            ->method('getCardRegistrationId')
            ->willReturn(1234);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('has')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn(true);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('get')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn($cardSessionMock);

        $cardRegistrationMock = $this->getMock('MangoPay\CardRegistration');

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Get')
            ->with(1234)
            ->willReturn($cardRegistrationMock);

        $cardRegistrationMock2 = $this->getMock('MangoPay\CardRegistration');
        $cardRegistrationMock2->RegistrationData = 'data=value';
        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $cardRegistrationMock2Ret = clone $cardRegistrationMock2;
        $cardRegistrationMock2Ret->CardId = 1234;
        $cardRegistrationMock2Ret->Status = 'VALIDATED';

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Update')
            ->with($cardRegistrationMock2)
            ->willReturn($cardRegistrationMock2Ret);

        $this->getEventDispatcherInterfaceMock()
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                MangoPayEvents::CARD_REGISTRATION_VALIDATED,
                new RegistrationEvent(
                    $cardSessionMock,
                    $cardRegistrationMock2Ret,
                    $responseMock
                )
            );

        $service = $this->buildService('routerNameValue');
        $this->assertEquals($service, $service->processMangoPayValidReturn('abcdef', 'value', $responseMock));
    }

    public function testProcessMangoPayValidReturnMangoExceptionError()
    {
        $cardSessionMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\CardRegistrationSession', [], [], '', false);
        $cardSessionMock->expects($this->once())
            ->method('getCardRegistrationId')
            ->willReturn(1234);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('has')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn(true);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('get')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn($cardSessionMock);

        $cardRegistrationMock = $this->getMock('MangoPay\CardRegistration');

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Get')
            ->with(1234)
            ->willReturn($cardRegistrationMock);

        $cardRegistrationMock2 = $this->getMock('MangoPay\CardRegistration');
        $cardRegistrationMock2->RegistrationData = 'data=value';
        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $cardRegistrationMock2Ret = clone $cardRegistrationMock2;
        $cardRegistrationMock2Ret->CardId = 1234;
        $cardRegistrationMock2Ret->Status = 'ERROR';

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Update')
            ->with($cardRegistrationMock2)
            ->willReturn($cardRegistrationMock2Ret);

        $this->getEventDispatcherInterfaceMock()
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                MangoPayEvents::CARD_REGISTRATION_ERROR_IN_VALIDATING,
                new RegistrationEvent(
                    $cardSessionMock,
                    $cardRegistrationMock2Ret,
                    $responseMock
                )
            );

        $service = $this->buildService('routerNameValue');
        $this->assertEquals($service, $service->processMangoPayValidReturn('abcdef', 'value', $responseMock));
    }

    public function testProcessMangoPayValidReturnMangoExceptionException()
    {
        $cardSessionMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\CardRegistrationSession', [], [], '', false);
        $cardSessionMock->expects($this->once())
            ->method('getCardRegistrationId')
            ->willReturn(1234);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('has')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn(true);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('get')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn($cardSessionMock);

        $cardRegistrationMock = $this->getMock('MangoPay\CardRegistration');

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Get')
            ->with(1234)
            ->willReturn($cardRegistrationMock);

        $cardRegistrationMock2 = $this->getMock('MangoPay\CardRegistration');
        $cardRegistrationMock2->RegistrationData = 'data=value';
        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $cardRegistrationMock2Ret = clone $cardRegistrationMock2;
        $cardRegistrationMock2Ret->CardId = 1234;
        $cardRegistrationMock2Ret->Status = 'ERROR';

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Update')
            ->with($cardRegistrationMock2)
            ->willThrowException(new \Exception('Error'));

        $this->getEventDispatcherInterfaceMock()
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                MangoPayEvents::CARD_REGISTRATION_ERROR_IN_VALIDATING,
                new RegistrationEvent(
                    $cardSessionMock,
                    $cardRegistrationMock2,
                    $responseMock
                )
            );

        $service = $this->buildService('routerNameValue');
        $this->assertEquals($service, $service->processMangoPayValidReturn('abcdef', 'value', $responseMock));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testProcessMangoPayErrorExceptionOnSessionNotFound()
    {
        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('has')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn(false);

        $this->getApiCardRegistrationsMock()
            ->expects($this->never())
            ->method('Get');

        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $this->buildService('routerNameValue')->processMangoPayError('abcdef', 'value', $responseMock);
    }

    /**
     * @expectedException \UniAlteri\MangoPayBundle\Exception\BadMangoReturnException
     */
    public function testProcessMangoPayErrorMangoExceptionOnErrorNotFound()
    {
        $cardSessionMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\CardRegistrationSession', [], [], '', false);
        $cardSessionMock->expects($this->once())
            ->method('getCardRegistrationId')
            ->willReturn(1234);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('has')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn(true);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('get')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn($cardSessionMock);

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Get')
            ->with(1234)
            ->willReturn(null);

        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $this->buildService('routerNameValue')->processMangoPayError('abcdef', 'value', $responseMock);
    }

    public function testProcessMangoPayErrorMangoExceptionValidating()
    {
        $cardSessionMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\CardRegistrationSession', [], [], '', false);
        $cardSessionMock->expects($this->once())
            ->method('getCardRegistrationId')
            ->willReturn(1234);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('has')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn(true);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('get')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn($cardSessionMock);

        $cardRegistrationMock = $this->getMock('MangoPay\CardRegistration');

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Get')
            ->with(1234)
            ->willReturn($cardRegistrationMock);

        $cardRegistrationMock2 = $this->getMock('MangoPay\CardRegistration');
        $cardRegistrationMock2->RegistrationData = 'errorCode=value';
        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $cardRegistrationMock2Ret = clone $cardRegistrationMock2;
        $cardRegistrationMock2Ret->CardId = 1234;
        $cardRegistrationMock2Ret->Status = 'ERROR';

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Update')
            ->with($cardRegistrationMock2)
            ->willReturn($cardRegistrationMock2Ret);

        $this->getEventDispatcherInterfaceMock()
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                MangoPayEvents::CARD_REGISTRATION_ERROR,
                new RegistrationEvent(
                    $cardSessionMock,
                    $cardRegistrationMock2Ret,
                    $responseMock
                )
            );

        $service = $this->buildService('routerNameValue');
        $this->assertEquals($service, $service->processMangoPayError('abcdef', 'value', $responseMock));
    }

    public function testProcessMangoPayErrorMangoExceptionException()
    {
        $cardSessionMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\CardRegistrationSession', [], [], '', false);
        $cardSessionMock->expects($this->once())
            ->method('getCardRegistrationId')
            ->willReturn(1234);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('has')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn(true);

        $this->getStorageServiceInterfaceMock()
            ->expects($this->once())
            ->method('get')
            ->with('MANGO_CARD_REGISTRATIONabcdef')
            ->willReturn($cardSessionMock);

        $cardRegistrationMock = $this->getMock('MangoPay\CardRegistration');

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Get')
            ->with(1234)
            ->willReturn($cardRegistrationMock);

        $cardRegistrationMock2 = $this->getMock('MangoPay\CardRegistration');
        $cardRegistrationMock2->RegistrationData = 'errorCode=value';
        $responseMock = $this->getMock('Symfony\Component\HttpFoundation\Response');

        $cardRegistrationMock2Ret = clone $cardRegistrationMock2;
        $cardRegistrationMock2Ret->CardId = 1234;
        $cardRegistrationMock2Ret->Status = 'ERROR';

        $this->getApiCardRegistrationsMock()
            ->expects($this->once())
            ->method('Update')
            ->with($cardRegistrationMock2)
            ->willThrowException(new \Exception('Error'));

        $this->getEventDispatcherInterfaceMock()
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                MangoPayEvents::CARD_REGISTRATION_ERROR,
                new RegistrationEvent(
                    $cardSessionMock,
                    $cardRegistrationMock2,
                    $responseMock
                )
            );

        $service = $this->buildService('routerNameValue');
        $this->assertEquals($service, $service->processMangoPayError('abcdef', 'value', $responseMock));
    }
}