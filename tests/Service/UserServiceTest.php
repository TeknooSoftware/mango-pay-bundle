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
namespace Teknoo\MangoPayBundle\Tests\Service;

use MangoPay\ApiUsers;
use MangoPay\UserNatural;
use Teknoo\MangoPayBundle\Entity\Interfaces\User\UserInterface;
use Teknoo\MangoPayBundle\Service\UserService;
use Teknoo\MangoPayBundle\Transcriber\UserTranscriber;

/**
 * Class UserServiceTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @covers \Teknoo\MangoPayBundle\Service\UserService
 */
class UserServiceTest extends \PHPUnit\Framework\TestCase
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
            $this->apiUsersMock = $this->createMock(ApiUsers::class);
        }

        return $this->apiUsersMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|UserTranscriber
     */
    protected function getUserTranscriberMock()
    {
        if (!$this->userTranscriberMock instanceof UserTranscriber) {
            $this->userTranscriberMock = $this->createMock(UserTranscriber::class);
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

        $userMock = $this->createMock(UserInterface::class);
        $this->getUserTranscriberMock()
            ->expects(self::once())
            ->method('toMango')
            ->with($userMock)
            ->willReturn($mangoUser);

        $this->getApiUsersMock()
            ->expects(self::once())
            ->method('Create')
            ->with($mangoUser)
            ->willReturn($mangoUser);

        self::assertEquals(1234, $this->buildService()->create($userMock));
    }
}
