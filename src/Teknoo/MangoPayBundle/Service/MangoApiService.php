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

namespace Teknoo\MangoPayBundle\Service;

use MangoPay\Libraries\IStorageStrategy;
use MangoPay\MangoPayApi;

/**
 * Class MangoApi.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class MangoApiService
{
    /**
     * @var MangoPayApi
     */
    protected $api;

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    private $clientPassPhrase;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var bool
     */
    protected $debugMode;

    /**
     * @var IStorageStrategy
     */
    private $storageStrategy;

    /**
     * @param MangoPayApi      $api
     * @param string           $clientId
     * @param string           $clientPassPhrase
     * @param string           $baseUrl
     * @param bool             $debugMode
     * @param IStorageStrategy $storageStrategy
     */
    public function __construct(
        MangoPayApi $api,
        $clientId,
        $clientPassPhrase,
        $baseUrl,
        $debugMode,
        IStorageStrategy $storageStrategy
    ) {
        $this->api = $api;
        $this->clientId = $clientId;
        $this->clientPassPhrase = $clientPassPhrase;
        $this->baseUrl = $baseUrl;
        $this->debugMode = $debugMode;
        $this->storageStrategy = $storageStrategy;

        $this->configureSdk();
    }

    /**
     * To configure the mango pay sdk.
     *
     * @return $this
     */
    protected function configureSdk()
    {
        $config = $this->api->Config;
        $config->ClientId = $this->clientId;
        $config->ClientPassword = $this->clientPassPhrase;
        $config->BaseUrl = $this->baseUrl;
        $config->DebugMode = $this->debugMode;
        $this->api->OAuthTokenManager->RegisterCustomStorageStrategy($this->storageStrategy);

        return $this;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return bool
     */
    public function isDebugMode()
    {
        return $this->debugMode;
    }

    /**
     * @return \MangoPay\ApiUsers
     */
    public function getApiUsers()
    {
        return $this->api->Users;
    }

    /**
     * @return \MangoPay\ApiWallets
     */
    public function getApiWallets()
    {
        return $this->api->Wallets;
    }

    /**
     * @return \MangoPay\ApiPayIns
     */
    public function getApiPayIns()
    {
        return $this->api->PayIns;
    }

    /**
     * @return \MangoPay\ApiPayOuts
     */
    public function getApiPayOuts()
    {
        return $this->api->PayOuts;
    }

    /**
     * @return \MangoPay\ApiTransfers
     * @deprecated Deprecated in 1.1, to be removed in 2.0
     */
    public function getApiTransferts()
    {
        @trigger_error('The ' . __METHOD__ . ' method has been deprecated in 1.1 and will be removed in 2.0.');
        return $this->getApiTransfers();
    }

    /**
     * @return \MangoPay\ApiTransfers
     */
    public function getApiTransfers()
    {
        return $this->api->Transfers;
    }

    /**
     * @return \MangoPay\ApiCards
     */
    public function getApiCards()
    {
        return $this->api->Cards;
    }

    /**
     * @return \MangoPay\ApiCardPreAuthorizations
     */
    public function getApiCardPreAuthorizations()
    {
        return $this->api->CardPreAuthorizations;
    }

    /**
     * @return \MangoPay\ApiCardRegistrations
     */
    public function getApiCardRegistrations()
    {
        return $this->api->CardRegistrations;
    }

    /**
     * @return \MangoPay\ApiRefunds
     */
    public function getApiRefunds()
    {
        return $this->api->Refunds;
    }

    /**
     * @return \MangoPay\ApiBankingAliases
     */
    public function getApiBankingAliases()
    {
        return $this->api->BankingAliases;
    }

    /**
     * @return \MangoPay\ApiHooks
     */
    public function getApiHooks()
    {
        return $this->api->Hooks;
    }

    /**
     * @return \MangoPay\ApiResponses
     */
    public function getApiResponses()
    {
        return $this->api->Responses;
    }

    /**
     * @return \MangoPay\ApiKycDocuments
     */
    public function getApiKycDocuments()
    {
        return $this->api->KycDocuments;
    }

    /**
     * @return \MangoPay\ApiClients
     */
    public function getApiClients()
    {
        return $this->api->Clients;
    }

    /**
     * @return \MangoPay\ApiEvents
     */
    public function getApiEvents()
    {
        return $this->api->Events;
    }

    /**
     * @return \MangoPay\ApiDisputes
     */
    public function getApiDisputes()
    {
        return $this->api->Disputes;
    }

    /**
     * @return \MangoPay\ApiDisputeDocuments
     */
    public function getApiDisputeDocuments()
    {
        return $this->api->DisputeDocuments;
    }

    /**
     * @return \MangoPay\ApiMandates
     */
    public function getApiMandates()
    {
        return $this->api->Mandates;
    }

    /**
     * @return \MangoPay\ApiReports
     */
    public function getApiReports()
    {
        return $this->api->Reports;
    }
}
