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

namespace Teknoo\MangoPayBundle\Entity;

use Teknoo\MangoPayBundle\Entity\Interfaces\User\UserInterface;

/**
 * Class CardRegistrationResult.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class CardRegistrationResult
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var string
     */
    protected $cardRegistrationUrl;

    /**
     * @var string
     */
    protected $returnUrl;

    /**
     * @var string
     */
    protected $data;

    /**
     * @var string
     */
    protected $accessKeyRef;

    /**
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user = null)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     *
     * @return self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getCardRegistrationUrl()
    {
        return $this->cardRegistrationUrl;
    }

    /**
     * @param string $cardRegistrationUrl
     *
     * @return self
     */
    public function setCardRegistrationUrl($cardRegistrationUrl)
    {
        $this->cardRegistrationUrl = $cardRegistrationUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @param string $returnUrl
     *
     * @return self
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     *
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessKeyRef()
    {
        return $this->accessKeyRef;
    }

    /**
     * @param string $accessKeyRef
     *
     * @return self
     */
    public function setAccessKeyRef($accessKeyRef)
    {
        $this->accessKeyRef = $accessKeyRef;

        return $this;
    }
}
