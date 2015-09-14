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

use MangoPay\CardRegistration;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;
use UniAlteri\MangoPayBundle\Entity\CardRegistrationSession;

/**
 * Class RegistrationEvent.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class RegistrationEvent extends Event
{
    /**
     * @var CardRegistrationSession
     */
    protected $registrationSession;

    /**
     * @var CardRegistration
     */
    protected $cardRegistration;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param CardRegistrationSession $registrationSession
     * @param CardRegistration        $cardRegistration
     * @param Response                $response
     */
    public function __construct(
        CardRegistrationSession $registrationSession,
        CardRegistration $cardRegistration,
        Response $response
    ) {
        $this->registrationSession = $registrationSession;
        $this->cardRegistration = $cardRegistration;
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
     * @return CardRegistrationSession
     */
    public function getRegistrationSession()
    {
        return $this->registrationSession;
    }

    /**
     * @return CardRegistration
     */
    public function getCardRegistration()
    {
        return $this->cardRegistration;
    }
}
