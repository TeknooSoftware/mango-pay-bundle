<?php

namespace UniAlteri\MangoPayBundle\Tests\Entity;

/**
 * Class CardRegistrationSessionTest
 * @package UniAlteri\MangoPayBundle\Tests\Entity
 * @covers UniAlteri\MangoPayBundle\Entity\CardRegistrationSession
 */
class CardRegistrationSessionTest extends \PHPUnit_Framework_TestCase
{
    use EntityTestTrait;

    /**
     * Return the canonical class name of the tested entity
     * @return string
     */
    protected function getEntityClassName()
    {
        return 'UniAlteri\MangoPayBundle\Entity\CardRegistrationSession';
    }

    public function testUser()
    {
        $userMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\UserInterface');
        $this->checkGetter('user', $userMock);
        $this->checkSetter('user', $userMock);
    }

    public function testSessionId()
    {
        $this->checkGetter('sessionId', 'abcdef1234');
    }

    public function testCardRegistrationId()
    {
        $this->checkGetter('cardRegistrationId', 'abcdef1234');
        $this->checkSetter('cardRegistrationId', 'abcdef1234');
    }

    public function testBusinessData()
    {
        $this->checkGetter('businessData', ['foo'=>'bar']);
        $this->checkSetter('businessData', ['foo'=>'bar']);
    }
}