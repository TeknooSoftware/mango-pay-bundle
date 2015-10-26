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

namespace Teknoo\MangoPayBundle\Tests\Event;

use MangoPay\CardRegistration;
use Symfony\Component\HttpFoundation\Response;
use Teknoo\MangoPayBundle\Entity\CardRegistrationSession;
use Teknoo\MangoPayBundle\Event\RegistrationEvent;

/**
 * Class RegistrationEventTest.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 *
 * @covers Teknoo\MangoPayBundle\Event\RegistrationEvent
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
            $this->registrationSessionMock = $this->getMock('Teknoo\MangoPayBundle\Entity\CardRegistrationSession', [], [], '', false);
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
