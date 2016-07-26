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
namespace Teknoo\MangoPayBundle\Tests\DependencyInjection;

use Teknoo\MangoPayBundle\DependencyInjection\TeknooMangoPayExtension;

/**
 * Class TeknooMangoPayExtensionTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @covers Teknoo\MangoPayBundle\DependencyInjection\TeknooMangoPayExtension
 */
class TeknooMangoPayExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return TeknooMangoPayExtension
     */
    public function buildExtension()
    {
        return new TeknooMangoPayExtension();
    }

    public function testLoad()
    {
        $containerMock = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder', [], [], '', false);

        $containerMock->expects($this->atLeastOnce())->method('setParameter');
        $containerMock->expects($this->atLeastOnce())->method('setDefinition');

        $this->buildExtension()->load([], $containerMock);
    }
}
