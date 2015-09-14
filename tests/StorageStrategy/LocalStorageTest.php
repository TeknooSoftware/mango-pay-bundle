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

namespace UniAlteri\MangoPayBundle\Tests\StorageStrategy;

use UniAlteri\MangoPayBundle\StorageStrategy\LocalStorage;

/**
 * Class LocalStorageTest.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 *
 * @covers UniAlteri\MangoPayBundle\StorageStrategy\LocalStorage
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

        $OAuthMock = $this->getMock('MangoPay\Libraries\OAuthToken', [], [], '', false);
        $OAuthMock2 = $this->getMock('MangoPay\Libraries\OAuthToken', [], [], '', false);

        $this->assertNull($localStorage->Get());
        $this->assertEquals($localStorage, $localStorage->Store($OAuthMock));
        $this->assertEquals($OAuthMock, $localStorage->Get());
        $this->assertEquals($OAuthMock, $localStorage->Get());
        $this->assertEquals($OAuthMock, $localStorage->Get());
        $this->assertEquals($localStorage, $localStorage->Store($OAuthMock2));
        $this->assertEquals($OAuthMock2, $localStorage->Get());
    }
}
