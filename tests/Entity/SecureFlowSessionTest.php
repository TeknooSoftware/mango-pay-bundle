<?php

namespace UniAlteri\MangoPayBundle\Tests\Entity;

/**
 * Class SecureFlowSession
 * @package UniAlteri\MangoPayBundle\Tests\Entity
 * @covers UniAlteri\MangoPayBundle\Entity\SecureFlowSession
 */
class SecureFlowSession extends \PHPUnit_Framework_TestCase
{
    use EntityTestTrait;

    /**
     * Return the canonical class name of the tested entity
     * @return string
     */
    protected function getEntityClassName()
    {
        return 'UniAlteri\MangoPayBundle\Entity\SecureFlowSession';
    }

    public function testUser()
    {
        $userMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\UserInterface');
        $this->checkGetter('user', $userMock);
        $this->checkSetter('user', $userMock);
    }

    public function testPayInId()
    {
        $this->checkGetter('payInId', 1234);
        $this->checkSetter('payInId', 1234);
    }

    public function testBusinessData()
    {
        $this->checkGetter('businessData', ['foo'=>'bar']);
        $this->checkSetter('businessData', ['foo'=>'bar']);
    }
}