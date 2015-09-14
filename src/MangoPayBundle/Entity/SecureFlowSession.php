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
 * @license     http://teknoo.it/license/gpl-3.0     GPL v3 License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\MangoPayBundle\Entity;

use UniAlteri\MangoPayBundle\Entity\Interfaces\User\UserInterface;

/**
 * Class SecureFlowSession
 * @package UniAlteri\MangoPayBundle\Entity
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @license     http://teknoo.it/license/gpl-3.0     GPL v3 License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class SecureFlowSession
{
    /**
     * @var int
     */
    protected $payInId;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var mixed
     */
    protected $businessData;

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     * @return self
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return int
     */
    public function getPayInId()
    {
        return $this->payInId;
    }

    /**
     * @param int $payInId
     * @return $this
     */
    public function setPayInId($payInId)
    {
        $this->payInId = $payInId;

        return $this;
    }

    /**
     * To return from session some values needed by your business services to process answer of Mango
     * @return mixed
     */
    public function getBusinessData()
    {
        return $this->businessData;
    }

    /**
     * To register in a session some values needed by your business services to process answer of Mango
     * @param mixed $businessData
     * @return self
     */
    public function setBusinessData($businessData)
    {
        $this->businessData = $businessData;

        return $this;
    }
}