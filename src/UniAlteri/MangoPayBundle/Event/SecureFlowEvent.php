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

namespace UniAlteri\MangoPayBundle\Event;

use MangoPay\PayIn;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;
use UniAlteri\MangoPayBundle\Entity\SecureFlowSession;

/**
 * Class SecureFlowEvent.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class SecureFlowEvent extends Event
{
    /**
     * @var SecureFlowSession
     */
    protected $secureFlowSession;

    /**
     * @var PayIn
     */
    protected $payIn;

    /**
     * @var Response
     */
    protected $response;

    /**n
     * @param PayIn $payIn
     * @param Response $response
     * @param SecureFlowSession|null $secureFlowSession
     */
    public function __construct(
        PayIn $payIn,
        Response $response,
        SecureFlowSession $secureFlowSession = null
    ) {
        $this->secureFlowSession = $secureFlowSession;
        $this->payIn = $payIn;
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return PayIn
     */
    public function getPayIn()
    {
        return $this->payIn;
    }

    /**
     * @return SecureFlowSession
     */
    public function getSecureFlowSession()
    {
        return $this->secureFlowSession;
    }
}
