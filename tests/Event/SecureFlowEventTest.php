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
namespace Teknoo\MangoPayBundle\Tests\Event;

use MangoPay\PayIn;
use Symfony\Component\HttpFoundation\Response;
use Teknoo\MangoPayBundle\Entity\SecureFlowSession;
use Teknoo\MangoPayBundle\Event\SecureFlowEvent;

/**
 * Class SecureFlowEventTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @covers \Teknoo\MangoPayBundle\Event\SecureFlowEvent
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
            $this->secureFlowSessionMock = $this->createMock(SecureFlowSession::class);
        }

        return $this->secureFlowSessionMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PayIn
     */
    protected function getPayInMock()
    {
        if (!$this->payInMock instanceof PayIn) {
            $this->payInMock = $this->createMock(PayIn::class);
        }

        return $this->payInMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Response
     */
    protected function getResponseMock()
    {
        if (!$this->responseMock instanceof Response) {
            $this->responseMock = $this->createMock(Response::class);
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
        self::assertEquals(
            $this->getResponseMock(),
            $this->buildService()->getResponse()
        );
    }

    public function testGetPayIn()
    {
        self::assertEquals(
            $this->getPayInMock(),
            $this->buildService()->getPayIn()
        );
    }

    public function testGetSecureFlowSession()
    {
        self::assertEquals(
            $this->getSecureFlowSessionMock(),
            $this->buildService()->getSecureFlowSession()
        );
    }
}
