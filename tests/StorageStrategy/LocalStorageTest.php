<?php

namespace UniAlteri\MangoPayBundle\Tests\StorageStrategy;

use UniAlteri\MangoPayBundle\StorageStrategy\LocalStorage;

/**
 * Class LocalStorageTest
 * @package UniAlteri\MangoPayBundle\Tests\StorageStrategy
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