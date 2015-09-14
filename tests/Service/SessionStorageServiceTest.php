<?php

namespace UniAlteri\MangoPayBundle\Tests\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UniAlteri\MangoPayBundle\Service\SessionStorageService;

/**
 * Class SessionStorageServiceTest
 * @package UniAlteri\MangoPayBundle\Tests\Service
 * @covers UniAlteri\MangoPayBundle\Service\SessionStorageService
 */
class SessionStorageServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SessionInterface
     */
    protected $sessionMock;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|SessionInterface
     */
    protected function getSessionInterfaceMock()
    {
        if (!$this->sessionMock instanceof SessionInterface) {
            $this->sessionMock = $this->getMock('Symfony\Component\HttpFoundation\Session\SessionInterface', [], [], '', false);
        }

        return $this->sessionMock;
    }

    /**
     * @return SessionStorageService
     */
    public function buildService()
    {
        return new SessionStorageService(
            $this->getSessionInterfaceMock()
        );
    }

    public function testAll()
    {
        $this->getSessionInterfaceMock()
            ->expects($this->once())
            ->method('all')
            ->willReturn(['foo'=>'bar']);

        $this->assertEquals(
            ['foo'=>'bar'],
            $this->buildService()->all()
        );
    }

    public function testGet()
    {
        $this->getSessionInterfaceMock()
            ->expects($this->once())
            ->method('get')
            ->with('fooBar')
            ->willReturn('Value');

        $this->assertEquals(
            'Value',
            $this->buildService()->get('fooBar')
        );
    }

    public function testSet()
    {
        $this->getSessionInterfaceMock()
            ->expects($this->once())
            ->method('set')
            ->with('fooBar', 'Value')
            ->willReturn('Value');

        $service = $this->buildService();
        $this->assertEquals(
            $service,
            $service->set('fooBar', 'Value')
        );
    }

    public function testHasTrue()
    {
        $this->getSessionInterfaceMock()
            ->expects($this->once())
            ->method('has')
            ->with('fooBar')
            ->willReturn(true);

        $this->assertTrue(
            $this->buildService()->has('fooBar')
        );
    }

    public function testHasFalse()
    {
        $this->getSessionInterfaceMock()
            ->expects($this->once())
            ->method('has')
            ->with('fooBar')
            ->willReturn(false);

        $this->assertFalse(
            $this->buildService()->has('fooBar')
        );
    }
}