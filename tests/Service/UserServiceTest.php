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

namespace UniAlteri\MangoPayBundle\Tests\Service;

use MangoPay\ApiUsers;
use MangoPay\UserNatural;
use UniAlteri\MangoPayBundle\Service\UserService;
use UniAlteri\MangoPayBundle\Transcriber\UserTranscriber;

/**
 * Class UserServiceTest.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 *
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
