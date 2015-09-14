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

namespace UniAlteri\MangoPayBundle\Tests\Service;

use MangoPay\Libraries\IStorageStrategy;
use MangoPay\MangoPayApi;
use UniAlteri\MangoPayBundle\Service\MangoApiService;

/**
 * Class MangoApiServiceTest.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 *
 * @covers UniAlteri\MangoPayBundle\Service\MangoApiService
 */
class MangoApiServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MangoPayApi
     */
    protected $apiMock;

    /**
     * @var IStorageStrategy
     */
    protected $storageStrategyMock;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|MangoPayApi
     */
    protected function getMangoPayApiMock()
    {
        if (!$this->apiMock instanceof MangoPayApi) {
            $this->apiMock = $this->getMock('MangoPay\MangoPayApi');
        }

        return $this->apiMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|IStorageStrategy
     */
    protected function getIStorageStrategyMock()
    {
        if (!$this->storageStrategyMock instanceof IStorageStrategy) {
            $this->storageStrategyMock = $this->getMock('MangoPay\Libraries\IStorageStrategy');
        }

        return $this->storageStrategyMock;
    }

    /**
     * @param string $clientId
     * @param string $clientPassPhrase
     * @param string $baseUrl
     * @param string $debugMode
     *
     * @return MangoApiService
     */
    public function buildService($clientId, $clientPassPhrase, $baseUrl, $debugMode)
    {
        return new MangoApiService(
            $this->getMangoPayApiMock(),
            $clientId,
            $clientPassPhrase,
            $baseUrl,
            $debugMode,
            $this->getIStorageStrategyMock()
        );
    }

    public function testConfiguration()
    {
        $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $api = $this->getMangoPayApiMock();
        $config = $api->Config;
        $this->assertEquals('clientIdValue', $config->ClientId);
        $this->assertEquals('clientPassPhraseValue', $config->ClientPassword);
        $this->assertEquals('http://foo.bar.com', $config->BaseUrl);
        $this->assertEquals(true, $config->DebugMode);

        $tokenMock = $this->getMock('MangoPay\Libraries\OAuthToken', [], [], '', false);
        $this->getIStorageStrategyMock()->expects($this->once())->method('Store')->with($tokenMock);
        $api->OAuthTokenManager->StoreToken($tokenMock);
    }

    public function testGetClientId()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $this->assertEquals('clientIdValue', $service->getClientId());
    }

    public function testGetBaseUrl()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $this->assertEquals('http://foo.bar.com', $service->getBaseUrl());
    }

    public function testIsDebugMode()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $this->assertTrue($service->isDebugMode());
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', false);
        $this->assertFalse($service->isDebugMode());
    }

    public function testGetApiUsers()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $this->assertSame(
            $this->getMangoPayApiMock()->Users,
            $service->getApiUsers()
        );
    }

    public function testGetApiWallets()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $this->assertSame(
            $this->getMangoPayApiMock()->Wallets,
            $service->getApiWallets()
        );
    }

    public function testGetApiPayIns()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $this->assertSame(
            $this->getMangoPayApiMock()->PayIns,
            $service->getApiPayIns()
        );
    }

    public function testGetApiPayOuts()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $this->assertSame(
            $this->getMangoPayApiMock()->PayOuts,
            $service->getApiPayOuts()
        );
    }

    public function testGetApiTransferts()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $this->assertSame(
            $this->getMangoPayApiMock()->Transfers,
            $service->getApiTransferts()
        );
    }

    public function testGetApiCards()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $this->assertSame(
            $this->getMangoPayApiMock()->Cards,
            $service->getApiCards()
        );
    }

    public function testGetApiCardPreAuthorizations()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $this->assertSame(
            $this->getMangoPayApiMock()->CardPreAuthorizations,
            $service->getApiCardPreAuthorizations()
        );
    }

    public function testGetApiCardRegistrations()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $this->assertSame(
            $this->getMangoPayApiMock()->CardRegistrations,
            $service->getApiCardRegistrations()
        );
    }

    public function testGetApiRefunds()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        $this->assertSame(
            $this->getMangoPayApiMock()->Refunds,
            $service->getApiRefunds()
        );
    }
}
