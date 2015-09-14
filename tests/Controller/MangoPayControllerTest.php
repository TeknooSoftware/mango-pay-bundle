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
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\MangoPayBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use UniAlteri\MangoPayBundle\Service\CardRegistrationService;
use UniAlteri\MangoPayBundle\Service\SecureFlowService;

/**
 * Class MangoPayControllerTest.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 *
 * @covers UniAlteri\MangoPayBundle\Controller\MangoPayController
 * @covers UniAlteri\MangoPayBundle\UniAlteriMangoPayBundle
 */
class MangoPayControllerTest extends WebTestCase
{
    /**
     * @var CardRegistrationService
     */
    protected $cardRegistrationServiceMock;

    /**
     * @var SecureFlowService
     */
    protected $secureFlowServiceMock;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|CardRegistrationService
     */
    protected function getCardRegistrationServiceMock()
    {
        if (!$this->cardRegistrationServiceMock instanceof CardRegistrationService) {
            $this->cardRegistrationServiceMock = $this->getMock('UniAlteri\MangoPayBundle\Service\CardRegistrationService', [], [], '', false);
        }

        return $this->cardRegistrationServiceMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|SecureFlowService
     */
    protected function getSecureFlowServiceMock()
    {
        if (!$this->secureFlowServiceMock instanceof SecureFlowService) {
            $this->secureFlowServiceMock = $this->getMock('UniAlteri\MangoPayBundle\Service\SecureFlowService', [], [], '', false);
        }

        return $this->secureFlowServiceMock;
    }

    public function testCardRegistrationReturnActionError()
    {
        $client = static::createClient();

        $container = $client->getContainer();
        $container->set('unialteri.mangopaybundle.service.card_registration', $this->getCardRegistrationServiceMock());

        $this->getCardRegistrationServiceMock()
            ->expects($this->never())
            ->method('processMangoPayValidReturn');

        $this->getCardRegistrationServiceMock()
            ->expects($this->once())
            ->method('processMangoPayError')
            ->with(
                'registrationSessionIdValue',
                'errorValue',
                $this->callback(function ($response) {
                    return $response instanceof Response;
                })
            )->willReturnCallback(function ($sessionId, $errorCode, Response $response) {
                $response->headers->set('Location', 'https://foo.bar.com');
            });

        $client->request('GET', '/mango-pay/card-registration/return/registrationSessionIdValue?errorCode=errorValue');

        $this->assertEquals('https://foo.bar.com', $client->getResponse()->headers->get('Location'));
    }

    public function testCardRegistrationReturnActionErrorEmpty()
    {
        $client = static::createClient();

        $container = $client->getContainer();
        $container->set('unialteri.mangopaybundle.service.card_registration', $this->getCardRegistrationServiceMock());

        $this->getCardRegistrationServiceMock()
            ->expects($this->never())
            ->method('processMangoPayValidReturn');

        $this->getCardRegistrationServiceMock()
            ->expects($this->once())
            ->method('processMangoPayError')
            ->with(
                'registrationSessionIdValue',
                null,
                $this->callback(function ($response) {
                    return $response instanceof Response;
                })
            )->willReturnCallback(function ($sessionId, $errorCode, Response $response) {
                $response->headers->set('Location', 'https://foo.bar.com');
            });

        $client->request('GET', '/mango-pay/card-registration/return/registrationSessionIdValue');

        $this->assertEquals('https://foo.bar.com', $client->getResponse()->headers->get('Location'));
    }

    public function testCardRegistrationReturnActionSuccess()
    {
        $client = static::createClient();

        $container = $client->getContainer();
        $container->set('unialteri.mangopaybundle.service.card_registration', $this->getCardRegistrationServiceMock());

        $this->getCardRegistrationServiceMock()
            ->expects($this->never())
            ->method('processMangoPayError');

        $this->getCardRegistrationServiceMock()
            ->expects($this->once())
            ->method('processMangoPayValidReturn')
            ->with(
                'registrationSessionIdValue',
                'dataValue',
                $this->callback(function ($response) {
                    return $response instanceof Response;
                })
            )->willReturnCallback(function ($sessionId, $errorCode, Response $response) {
                $response->headers->set('Location', 'https://foo.bar.com');
            });

        $client->request('GET', '/mango-pay/card-registration/return/registrationSessionIdValue?data=dataValue');

        $this->assertEquals('https://foo.bar.com', $client->getResponse()->headers->get('Location'));
    }

    public function testSecureFlowReturnActionError()
    {
        $client = static::createClient();

        $container = $client->getContainer();
        $container->set('unialteri.mangopaybundle.service.secure_flow', $this->getSecureFlowServiceMock());

        $this->getSecureFlowServiceMock()
            ->expects($this->never())
            ->method('processMangoPayReturn');

        $client->request('GET', '/mango-pay/3dsecure/return');

        $this->assertNull($client->getResponse()->headers->get('Location'));
    }

    public function testSecureFlowReturnActionSuccess()
    {
        $client = static::createClient();

        $container = $client->getContainer();
        $container->set('unialteri.mangopaybundle.service.secure_flow', $this->getSecureFlowServiceMock());

        $this->getSecureFlowServiceMock()
            ->expects($this->once())
            ->method('processMangoPayReturn')
            ->with(
                'transactionIdValue',
                $this->callback(function ($response) {
                    return $response instanceof Response;
                })
            )->willReturnCallback(function ($transactionId, Response $response) {
                $response->headers->set('Location', 'https://foo.bar.com');
            });

        $client->request('GET', '/mango-pay/3dsecure/return?transactionId=transactionIdValue');

        $this->assertEquals('https://foo.bar.com', $client->getResponse()->headers->get('Location'));
    }
}
