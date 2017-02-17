<?php

/**
 * MangoPayBundle.
 *
 * LICENSE
 *
 * This source file is subject to the MIT license and the version 3 of the GPL3
 * license that are bundled with this package in the folder licences
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to richarddeloge@gmail.com so we can send you a copy immediately.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
namespace Teknoo\MangoPayBundle\Tests\Service;

use MangoPay\ApiPayIns;
use MangoPay\PayIn;
use MangoPay\PayInExecutionDetailsDirect;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Teknoo\MangoPayBundle\Entity\SecureFlowSession;
use Teknoo\MangoPayBundle\Event\MangoPayEvents;
use Teknoo\MangoPayBundle\Event\SecureFlowEvent;
use Teknoo\MangoPayBundle\Service\Interfaces\StorageServiceInterface;
use Teknoo\MangoPayBundle\Service\SecureFlowService;

/**
 * Class SecureFlowServiceTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @covers \Teknoo\MangoPayBundle\Service\SecureFlowService
 */
class SecureFlowServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Router
     */
    protected $routerMock;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatchedMock;

    /**
     * @var ApiPayIns
     */
    protected $mangoPayPayInsApiMock;

    /**
     * @var StorageServiceInterface
     */
    protected $storageServiceMock;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Router
     */
    protected function getRouterMock()
    {
        if (!$this->routerMock instanceof Router) {
            $this->routerMock = $this->createMock(Router::class);
        }

        return $this->routerMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EventDispatcherInterface
     */
    protected function getEventDispatcherInterfaceMock()
    {
        if (!$this->eventDispatchedMock instanceof EventDispatcherInterface) {
            $this->eventDispatchedMock = $this->createMock(EventDispatcherInterface::class);
        }

        return $this->eventDispatchedMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ApiPayIns
     */
    protected function getApiPayInsMock()
    {
        if (!$this->mangoPayPayInsApiMock instanceof ApiPayIns) {
            $this->mangoPayPayInsApiMock = $this->createMock(ApiPayIns::class);
        }

        return $this->mangoPayPayInsApiMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|StorageServiceInterface
     */
    protected function getStorageServiceInterfaceMock()
    {
        if (!$this->storageServiceMock instanceof StorageServiceInterface) {
            $this->storageServiceMock = $this->createMock(StorageServiceInterface::class);
        }

        return $this->storageServiceMock;
    }

    /**
     * @param string $routerName
     *
     * @return SecureFlowService
     */
    public function buildService($routerName)
    {
        return new SecureFlowService(
            $this->getRouterMock(),
            $routerName,
            $this->getEventDispatcherInterfaceMock(),
            $this->getApiPayInsMock(),
            $this->getStorageServiceInterfaceMock()
        );
    }

    public function testGetSecureFlowReturnUrl()
    {
        $this->getRouterMock()
            ->expects(self::once())
            ->method('generate')
            ->with('routerNameValue', [], Router::ABSOLUTE_URL)
            ->willReturn('http://foo.bar.com/return');

        self::assertEquals(
            'http://foo.bar.com/return',
            $this->buildService('routerNameValue')->getSecureFlowReturnUrl()
        );
    }

    public function testPrepareSecureFlowError()
    {
        $payInMock = new PayIn();
        $payInMock->Id = 1234;
        $payInMock->Status = 'ERROR';

        $secureFlowSessionMock = $this->createMock(SecureFlowSession::class);
        $secureFlowSessionMock->expects(self::once())->method('setPayInId')->with(1234)->willReturnSelf();

        $responseMock = $this->createMock(Response::class);
        $responseMock->expects(self::never())->method('setStatusCode');

        $service = $this->buildService('routerNameValue');
        self::assertEquals($service, $service->prepareSecureFlow($payInMock, $secureFlowSessionMock, $responseMock));
    }

    public function testPrepareSecureFlowSuccess()
    {
        $payInMock = new PayIn();
        $payInMock->Id = 1234;
        $payInMock->Status = 'SUCCESSFULL';

        $secureFlowSessionMock = $this->createMock(SecureFlowSession::class);
        $secureFlowSessionMock->expects(self::once())->method('setPayInId')->with(1234)->willReturnSelf();

        $responseMock = $this->createMock(Response::class);
        $responseMock->expects(self::never())->method('setStatusCode');

        $service = $this->buildService('routerNameValue');
        self::assertEquals($service, $service->prepareSecureFlow($payInMock, $secureFlowSessionMock, $responseMock));
    }

    public function testPrepareSecureFlowCreatedWithoutDetail()
    {
        $payInMock = new PayIn();
        $payInMock->Id = 1234;
        $payInMock->Status = 'CREATED';

        $secureFlowSessionMock = $this->createMock(SecureFlowSession::class);
        $secureFlowSessionMock->expects(self::once())->method('setPayInId')->with(1234)->willReturnSelf();

        $responseMock = $this->createMock(Response::class);
        $responseMock->expects(self::never())->method('setStatusCode');

        $service = $this->buildService('routerNameValue');
        self::assertEquals($service, $service->prepareSecureFlow($payInMock, $secureFlowSessionMock, $responseMock));
    }

    public function testPrepareSecureFlowCreatedWithDetail()
    {
        $payInDetail = new PayInExecutionDetailsDirect();
        $payInDetail->SecureModeRedirectURL = 'https://3d.secure.com/url';
        $payInMock = new PayIn();
        $payInMock->Id = 1234;
        $payInMock->Status = 'CREATED';
        $payInMock->ExecutionDetails = $payInDetail;

        $secureFlowSessionMock = $this->createMock(SecureFlowSession::class);
        $secureFlowSessionMock->expects(self::once())->method('setPayInId')->with(1234)->willReturnSelf();

        /*
         * @var Response|\PHPUnit_Framework_MockObject_MockObject
         */
        $responseMock = $this->getMockBuilder(Response::class)->getMock();
        $responseMock->expects(self::once())->method('setStatusCode')->with(302)->willReturnSelf();

        $service = $this->buildService('routerNameValue');
        self::assertEquals($service, $service->prepareSecureFlow($payInMock, $secureFlowSessionMock, $responseMock));
        self::assertEquals($responseMock->headers->get('Location'), 'https://3d.secure.com/url');
    }

    /**
     * @expectedException \Teknoo\MangoPayBundle\Exception\BadMangoReturnException
     */
    public function testProcessMangoPayReturnExceptionOnInvalidReturn()
    {
        /*
         * @var Response|\PHPUnit_Framework_MockObject_MockObject
         */
        $responseMock = $this->createMock(Response::class);

        $this->getApiPayInsMock()
            ->expects(self::once())
            ->method('Get')
            ->with(1234)
            ->willReturn(null);

        $this->buildService('routerNameValue')->processMangoPayReturn(1234, $responseMock);
    }

    public function testProcessMangoPayReturnOnError()
    {
        /*
         * @var Response|\PHPUnit_Framework_MockObject_MockObject
         */
        $responseMock = $this->createMock(Response::class);

        $payInMock = new PayIn();
        $payInMock->Id = 1234;
        $payInMock->Status = 'ERROR';

        $this->getApiPayInsMock()
            ->expects(self::once())
            ->method('Get')
            ->with(1234)
            ->willReturn($payInMock);

        $secureFlowSessionMock = $this->createMock(SecureFlowSession::class);
        $this->getStorageServiceInterfaceMock()
            ->expects(self::once())
            ->method('get')
            ->with('MANGO_SECURE_FLOW1234')
            ->willReturn($secureFlowSessionMock);

        $this->getEventDispatcherInterfaceMock()
            ->expects(self::once())
            ->method('dispatch')
            ->with(
                MangoPayEvents::SECURE_FLOW_ERROR,
                new SecureFlowEvent($payInMock, $responseMock, $secureFlowSessionMock)
            );

        $this->buildService('routerNameValue')->processMangoPayReturn(1234, $responseMock);
    }

    public function testProcessMangoPayReturnOnSuccess()
    {
        /*
         * @var Response|\PHPUnit_Framework_MockObject_MockObject
         */
        $responseMock = $this->createMock(Response::class);

        $payInMock = new PayIn();
        $payInMock->Id = 1234;
        $payInMock->Status = 'SUCCEEDED';

        $this->getApiPayInsMock()
            ->expects(self::once())
            ->method('Get')
            ->with(1234)
            ->willReturn($payInMock);

        $secureFlowSessionMock = $this->createMock(SecureFlowSession::class);
        $this->getStorageServiceInterfaceMock()
            ->expects(self::once())
            ->method('get')
            ->with('MANGO_SECURE_FLOW1234')
            ->willReturn($secureFlowSessionMock);

        $this->getEventDispatcherInterfaceMock()
            ->expects(self::once())
            ->method('dispatch')
            ->with(
                MangoPayEvents::SECURE_FLOW_SUCCESS,
                new SecureFlowEvent($payInMock, $responseMock, $secureFlowSessionMock)
            );

        $this->buildService('routerNameValue')->processMangoPayReturn(1234, $responseMock);
    }
}
