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

namespace UniAlteri\MangoPayBundle\Tests\Entity;

/**
 * Class CardRegistrationResultTest.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 *
 * @covers UniAlteri\MangoPayBundle\Entity\CardRegistrationResult
 */
class CardRegistrationResultTest extends \PHPUnit_Framework_TestCase
{
    use EntityTestTrait;

    /**
     * Return the canonical class name of the tested entity.
     *
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
