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
 * to contact@uni-alteri.com so we can send you a copy immediately.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\MangoPayBundle\Tests\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UniAlteri\MangoPayBundle\Service\SessionStorageService;

/**
 * Class SessionStorageServiceTest.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 *
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
            ->willReturn(['foo' => 'bar']);

        $this->assertEquals(
            ['foo' => 'bar'],
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
