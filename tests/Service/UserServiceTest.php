<?php

namespace UniAlteri\MangoPayBundle\Tests\Service;

use MangoPay\ApiUsers;
use MangoPay\UserNatural;
use UniAlteri\MangoPayBundle\Service\UserService;
use UniAlteri\MangoPayBundle\Transcriber\UserTranscriber;

/**
 * Class UserServiceTest
 * @package UniAlteri\MangoPayBundle\Tests\Service
 * @covers UniAlteri\MangoPayBundle\Service\UserService
 */
class UserServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiUsers
     */
    protected $apiUsersMock;

    /**
     * @var UserTranscriber
     */
    protected $userTranscriberMock;

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ApiUsers
     */
    protected function getApiUsersMock()
    {
        if (!$this->apiUsersMock instanceof ApiUsers) {
            $this->apiUsersMock = $this->getMock('MangoPay\ApiUsers', [], [], '', false);
        }

        return $this->apiUsersMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|UserTranscriber
     */
    protected function getUserTranscriberMock()
    {
        if (!$this->userTranscriberMock instanceof UserTranscriber) {
            $this->userTranscriberMock = $this->getMock('UniAlteri\MangoPayBundle\Transcriber\UserTranscriber', [], [], '', false);
        }

        return $this->userTranscriberMock;
    }

    public function buildService()
    {
        return new UserService(
            $this->getApiUsersMock(),
            $this->getUserTranscriberMock()
        );
    }

    public function testCreate()
    {
        $mangoUser = new UserNatural();
        $mangoUser->Id = 1234;

        $userMock = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\UserInterface');
        $this->getUserTranscriberMock()
            ->expects($this->once())
            ->method('toMango')
            ->with($userMock)
            ->willReturn($mangoUser);

        $this->getApiUsersMock()
            ->expects($this->once())
            ->method('Create')
            ->with($mangoUser)
            ->willReturn($mangoUser);

        $this->assertEquals(1234, $this->buildService()->create($userMock));
    }
}