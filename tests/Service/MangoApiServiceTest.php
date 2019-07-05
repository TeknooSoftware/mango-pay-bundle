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

use MangoPay\Libraries\IStorageStrategy;
use MangoPay\Libraries\OAuthToken;
use MangoPay\MangoPayApi;
use Teknoo\MangoPayBundle\Service\MangoApiService;

/**
 * Class MangoApiServiceTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @covers \Teknoo\MangoPayBundle\Service\MangoApiService
 */
class MangoApiServiceTest extends \PHPUnit\Framework\TestCase
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
            $this->apiMock = $this->getMockBuilder(MangoPayApi::class)->getMock();
        }

        return $this->apiMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|IStorageStrategy
     */
    protected function getIStorageStrategyMock()
    {
        if (!$this->storageStrategyMock instanceof IStorageStrategy) {
            $this->storageStrategyMock = $this->createMock(IStorageStrategy::class);
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
        self::assertEquals('clientIdValue', $config->ClientId);
        self::assertEquals('clientPassPhraseValue', $config->ClientPassword);
        self::assertEquals('http://foo.bar.com', $config->BaseUrl);
        self::assertEquals(true, $config->DebugMode);

        $tokenMock = $this->createMock(OAuthToken::class);
        $this->getIStorageStrategyMock()->expects(self::once())->method('Store')->with($tokenMock);
        $api->OAuthTokenManager->StoreToken($tokenMock);
    }

    public function testGetApi()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock(),
            $service->getApi()
        );
    }

    public function testGetClientId()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertEquals('clientIdValue', $service->getClientId());
    }

    public function testGetBaseUrl()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertEquals('http://foo.bar.com', $service->getBaseUrl());
    }

    public function testIsDebugMode()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertTrue($service->isDebugMode());
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', false);
        self::assertFalse($service->isDebugMode());
    }

    public function testGetApiUsers()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Users,
            $service->getApiUsers()
        );
    }

    public function testGetApiWallets()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Wallets,
            $service->getApiWallets()
        );
    }

    public function testGetApiPayIns()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->PayIns,
            $service->getApiPayIns()
        );
    }

    public function testGetApiPayOuts()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->PayOuts,
            $service->getApiPayOuts()
        );
    }

    public function testGetApiTransfers()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Transfers,
            $service->getApiTransfers()
        );
    }

    public function testGetApiCards()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Cards,
            $service->getApiCards()
        );
    }

    public function testGetApiCardPreAuthorizations()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->CardPreAuthorizations,
            $service->getApiCardPreAuthorizations()
        );
    }

    public function testGetApiCardRegistrations()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->CardRegistrations,
            $service->getApiCardRegistrations()
        );
    }

    public function testGetApiRefunds()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Refunds,
            $service->getApiRefunds()
        );
    }

    public function testGetApiBankingAliases()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->BankingAliases,
            $service->getApiBankingAliases()
        );
    }

    public function testGetApiHooks()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Hooks,
            $service->getApiHooks()
        );
    }

    public function testGetApiResponses()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Responses,
            $service->getApiResponses()
        );
    }

    public function testGetApiKycDocuments()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->KycDocuments,
            $service->getApiKycDocuments()
        );
    }

    public function testGetApiClients()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Clients,
            $service->getApiClients()
        );
    }

    public function testGetApiEvents()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Events,
            $service->getApiEvents()
        );
    }

    public function testGetApiDisputes()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Disputes,
            $service->getApiDisputes()
        );
    }

    public function testGetApiDisputeDocuments()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->DisputeDocuments,
            $service->getApiDisputeDocuments()
        );
    }

    public function testGetApiMandates()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Mandates,
            $service->getApiMandates()
        );
    }

    public function testGetApiReports()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Reports,
            $service->getApiReports()
        );
    }

    public function testGetApiUboDeclarations()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->UboDeclarations,
            $service->getApiUboDeclarations()
        );
    }

    public function testGetApiBankAccounts()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->BankAccounts,
            $service->getApiBankAccounts()
        );
    }

    public function testGetApiRepudations()
    {
        $service = $this->buildService('clientIdValue', 'clientPassPhraseValue', 'http://foo.bar.com', true);
        self::assertSame(
            $this->getMangoPayApiMock()->Repudiations,
            $service->getApiRepudations()
        );
    }
}
