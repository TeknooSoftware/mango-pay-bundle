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
namespace Teknoo\MangoPayBundle\Tests\Entity;
use Teknoo\MangoPayBundle\Entity\Interfaces\User\UserInterface;

/**
 * Class CardRegistrationSessionTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @covers \Teknoo\MangoPayBundle\Entity\CardRegistrationSession
 */
class CardRegistrationSessionTest extends \PHPUnit\Framework\TestCase
{
    use EntityTestTrait;

    /**
     * Return the canonical class name of the tested entity.
     *
     * @return string
     */
    protected function getEntityClassName()
    {
        return 'Teknoo\MangoPayBundle\Entity\CardRegistrationSession';
    }

    public function testUser()
    {
        $userMock = $this->createMock(UserInterface::class);
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
        $this->checkGetter('businessData', ['foo' => 'bar']);
        $this->checkSetter('businessData', ['foo' => 'bar']);
    }
}
