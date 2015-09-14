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

namespace UniAlteri\MangoPayBundle\StorageStrategy;

use MangoPay\Libraries\IStorageStrategy;
use MangoPay\Libraries\OAuthToken;

/**
 * Class LocalStorage
 * @package UniAlteri\MangoPayBundle\Service
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @license     http://teknoo.it/license/gpl-3.0     GPL v3 License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class LocalStorage implements IStorageStrategy
{
    /**
     * @var OAuthToken
     */
    private $token;

    /**
     * Gets the current authorization token.
     * @return OAuthToken Currently stored token instance or null.
     */
    public function Get()
    {
        return $this->token;
    }

    /**
     * Stores authorization token passed as an argument.
     * @param OAuthToken $token Token instance to be stored.
     * @return self
     */
    public function Store($token)
    {
        $this->token = $token;

        return $this;
    }
}