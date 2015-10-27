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
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace Teknoo\MangoPayBundle\Service;

use MangoPay\ApiPayIns;
use MangoPay\PayIn;
use MangoPay\PayInExecutionDetails;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Teknoo\MangoPayBundle\Exception\BadMangoReturnException;
use Teknoo\MangoPayBundle\Entity\SecureFlowSession;
use Teknoo\MangoPayBundle\Event\MangoPayEvents;
use Teknoo\MangoPayBundle\Event\SecureFlowEvent;
use Teknoo\MangoPayBundle\Service\Interfaces\StorageServiceInterface;

/**
 * Class SecureFlowService.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class SecureFlowService
{
    const SESSION_PREFIX = 'MANGO_SECURE_FLOW';

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var string
     */
    protected $returnRouteName;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatched;

    /**
     * @var ApiPayIns
     */
    protected $mangoPayPayInsApi;

    /**
     * @var StorageServiceInterface
     */
    protected $storageService;

    /**
     * @param Router $router
     * @param $returnRouteName
     * @param EventDispatcherInterface $eventDispatched
     * @param ApiPayIns                $mangoPayPayInsApi
     * @param StorageServiceInterface  $storageService
     */
    public function __construct(
        Router $router,
        $returnRouteName,
        EventDispatcherInterface $eventDispatched,
        ApiPayIns $mangoPayPayInsApi,
        StorageServiceInterface $storageService
    ) {
        $this->router = $router;
        $this->returnRouteName = $returnRouteName;
        $this->eventDispatched = $eventDispatched;
        $this->mangoPayPayInsApi = $mangoPayPayInsApi;
        $this->storageService = $storageService;
    }

    /**
     * To get the url where the user is returned by mango pay server at end of the secure flow (aka 3D secure).
     *
     * @return string
     */
    public function getSecureFlowReturnUrl()
    {
        return $this->router->generate($this->returnRouteName, [], Router::ABSOLUTE_URL);
    }

    /***
     * @param PayIn $payIn
     * @param SecureFlowSession $session
     * @param Response $response
     * @return $this
     */
    public function prepareSecureFlow(PayIn $payIn, SecureFlowSession $session, Response $response)
    {
        $session->setPayInId($payIn->Id);
        $this->storageService->set(self::SESSION_PREFIX.$session->getPayInId(), $session);

        if ('CREATED' == $payIn->Status && $payIn->ExecutionDetails instanceof PayInExecutionDetails) {
            $response->setStatusCode(302);
            $response->headers->set('Location', $payIn->ExecutionDetails->SecureModeRedirectURL);
        }

        return $this;
    }

    /**
     * @param string   $transactionId
     * @param Response $response
     *
     * @return $this
     */
    public function processMangoPayReturn($transactionId, Response $response)
    {
        $payIn = $this->mangoPayPayInsApi->Get($transactionId);

        if (!$payIn instanceof PayIn) {
            throw new BadMangoReturnException('Error, return for '.$transactionId.' from Mango is invalid');
        }

        $session = $this->storageService->get(self::SESSION_PREFIX.$transactionId);

        if ('SUCCEEDED' === $payIn->Status) {
            $this->eventDispatched->dispatch(
                MangoPayEvents::SECURE_FLOW_SUCCESS,
                new SecureFlowEvent($payIn, $response, $session)
            );
        } else {
            $this->eventDispatched->dispatch(
                MangoPayEvents::SECURE_FLOW_ERROR,
                new SecureFlowEvent($payIn, $response, $session)
            );
        }
    }
}
