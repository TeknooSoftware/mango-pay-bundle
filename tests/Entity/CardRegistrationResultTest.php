<?php

namespace UniAlteri\MangoPayBundle\Tests\Entity;

/**
 * Class CardRegistrationResultTest
 * @package UniAlteri\MangoPayBundle\Tests\Entity
 * @covers UniAlteri\MangoPayBundle\Entity\CardRegistrationResult
 */
class CardRegistrationResultTest extends \PHPUnit_Framework_TestCase
{
    use EntityTestTrait;

    /**
     * Return the canonical class name of the tested entity
     * @return string
     */
    protected function getEntityClassName()
    {
        return 'UniAlteri\MangoPayBundle\Entity\CardRegistrationResult';
    }

    public function testUser()
    {
        $userMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\UserInterface');
        $this->checkGetter('user', $userMock);
        $this->checkSetter('user', $userMock);
    }

    public function testId()
    {
        $this->checkGetter('id', 'abcdef1234');
        $this->checkSetter('id', 'abcdef1234');
    }

    public function testCardRegistrationUrl()
    {
        $this->checkGetter('cardRegistrationUrl', 'abcdef1234');
        $this->checkSetter('cardRegistrationUrl', 'abcdef1234');
    }

    public function testReturnUrl()
    {
        $this->checkGetter('returnUrl', 'abcdef1234');
        $this->checkSetter('returnUrl', 'abcdef1234');
    }

    public function testData()
    {
        $this->checkGetter('data', 'abcdef1234');
        $this->checkSetter('data', 'abcdef1234');
    }

    public function testAccessKeyRef()
    {
        $this->checkGetter('accessKeyRef', 'abcdef1234');
        $this->checkSetter('accessKeyRef', 'abcdef1234');
    }
}