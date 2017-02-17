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
namespace Teknoo\MangoPayBundle\Tests\StorageStrategy;

use MangoPay\Libraries\OAuthToken;
use Teknoo\MangoPayBundle\StorageStrategy\LocalStorage;

/**
 * Class LocalStorageTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @covers \Teknoo\MangoPayBundle\StorageStrategy\LocalStorage
 */
class LocalStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return LocalStorage
     */
    public function buildService()
    {
        return new LocalStorage();
    }

    public function testStorage()
    {
        $localStorage = $this->buildService();

        $OAuthMock = $this->createMock(OAuthToken::class);
        $OAuthMock2 = $this->createMock(OAuthToken::class);

        self::assertNull($localStorage->Get());
        self::assertEquals($localStorage, $localStorage->Store($OAuthMock));
        self::assertEquals($OAuthMock, $localStorage->Get());
        self::assertEquals($OAuthMock, $localStorage->Get());
        self::assertEquals($OAuthMock, $localStorage->Get());
        self::assertEquals($localStorage, $localStorage->Store($OAuthMock2));
        self::assertEquals($OAuthMock2, $localStorage->Get());
    }
}
