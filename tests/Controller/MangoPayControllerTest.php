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
namespace Teknoo\MangoPayBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Teknoo\MangoPayBundle\Service\CardRegistrationService;
use Teknoo\MangoPayBundle\Service\SecureFlowService;

if (!class_exists('\PHPUnit_Framework_TestCase', false)) {
    \class_alias(TestCase::class, '\PHPUnit_Framework_TestCase');
}

/**
 * Class MangoPayControllerTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @covers \Teknoo\MangoPayBundle\Controller\MangoPayController
 * @covers \Teknoo\MangoPayBundle\TeknooMangoPayBundle
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
            $this->cardRegistrationServiceMock = $this->createMock(CardRegistrationService::class);
        }

        return $this->cardRegistrationServiceMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|SecureFlowService
     */
    protected function getSecureFlowServiceMock()
    {
        if (!$this->secureFlowServiceMock instanceof SecureFlowService) {
            $this->secureFlowServiceMock = $this->createMock(SecureFlowService::class);
        }

        return $this->secureFlowServiceMock;
    }

    public function testCardRegistrationReturnActionError()
    {
        $client = static::createClient();

        $container = $client->getContainer();
        $container->set('teknoo.mangopaybundle.service.card_registration', $this->getCardRegistrationServiceMock());

        $this->getCardRegistrationServiceMock()
            ->expects(self::never())
            ->method('processMangoPayValidReturn');

        $this->getCardRegistrationServiceMock()
            ->expects(self::once())
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

        self::assertEquals('https://foo.bar.com', $client->getResponse()->headers->get('Location'));
    }

    public function testCardRegistrationReturnActionErrorEmpty()
    {
        $client = static::createClient();

        $container = $client->getContainer();
        $container->set('teknoo.mangopaybundle.service.card_registration', $this->getCardRegistrationServiceMock());

        $this->getCardRegistrationServiceMock()
            ->expects(self::never())
            ->method('processMangoPayValidReturn');

        $this->getCardRegistrationServiceMock()
            ->expects(self::once())
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

        self::assertEquals('https://foo.bar.com', $client->getResponse()->headers->get('Location'));
    }

    public function testCardRegistrationReturnActionSuccess()
    {
        $client = static::createClient();

        $container = $client->getContainer();
        $container->set('teknoo.mangopaybundle.service.card_registration', $this->getCardRegistrationServiceMock());

        $this->getCardRegistrationServiceMock()
            ->expects(self::never())
            ->method('processMangoPayError');

        $this->getCardRegistrationServiceMock()
            ->expects(self::once())
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

        self::assertEquals('https://foo.bar.com', $client->getResponse()->headers->get('Location'));
    }

    public function testSecureFlowReturnActionError()
    {
        $client = static::createClient();

        $container = $client->getContainer();
        $container->set('teknoo.mangopaybundle.service.secure_flow', $this->getSecureFlowServiceMock());

        $this->getSecureFlowServiceMock()
            ->expects(self::never())
            ->method('processMangoPayReturn');

        $client->request('GET', '/mango-pay/3dsecure/return');

        self::assertNull($client->getResponse()->headers->get('Location'));
    }

    public function testSecureFlowReturnActionSuccess()
    {
        $client = static::createClient();

        $container = $client->getContainer();
        $container->set('teknoo.mangopaybundle.service.secure_flow', $this->getSecureFlowServiceMock());

        $this->getSecureFlowServiceMock()
            ->expects(self::once())
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

        self::assertEquals('https://foo.bar.com', $client->getResponse()->headers->get('Location'));
    }
}
