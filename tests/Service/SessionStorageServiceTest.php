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

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Teknoo\MangoPayBundle\Service\SessionStorageService;

/**
 * Class SessionStorageServiceTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @covers \Teknoo\MangoPayBundle\Service\SessionStorageService
 */
class SessionStorageServiceTest extends \PHPUnit\Framework\TestCase
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
            $this->sessionMock = $this->createMock(SessionInterface::class);
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
            ->expects(self::once())
            ->method('all')
            ->willReturn(['foo' => 'bar']);

        self::assertEquals(
            ['foo' => 'bar'],
            $this->buildService()->all()
        );
    }

    public function testGet()
    {
        $this->getSessionInterfaceMock()
            ->expects(self::once())
            ->method('get')
            ->with('fooBar')
            ->willReturn('Value');

        self::assertEquals(
            'Value',
            $this->buildService()->get('fooBar')
        );
    }

    public function testSet()
    {
        $this->getSessionInterfaceMock()
            ->expects(self::once())
            ->method('set')
            ->with('fooBar', 'Value')
            ->willReturn('Value');

        $service = $this->buildService();
        self::assertEquals(
            $service,
            $service->set('fooBar', 'Value')
        );
    }

    public function testHasTrue()
    {
        $this->getSessionInterfaceMock()
            ->expects(self::once())
            ->method('has')
            ->with('fooBar')
            ->willReturn(true);

        self::assertTrue(
            $this->buildService()->has('fooBar')
        );
    }

    public function testHasFalse()
    {
        $this->getSessionInterfaceMock()
            ->expects(self::once())
            ->method('has')
            ->with('fooBar')
            ->willReturn(false);

        self::assertFalse(
            $this->buildService()->has('fooBar')
        );
    }
}
