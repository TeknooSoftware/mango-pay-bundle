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

namespace Teknoo\MangoPayBundle\Tests\DependencyInjection;

use Teknoo\MangoPayBundle\DependencyInjection\UniAlteriMangoPayExtension;

/**
 * Class UniAlteriMangoPayExtensionTest.
 *
 * @copyright   Copyright (c) 2009-2016 Uni Alteri (http://uni-alteri.com)
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (r.deloge@uni-alteri.com)
 *
 * @link        http://teknoo.it/mangopay-bundle Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 *
 * @covers Teknoo\MangoPayBundle\DependencyInjection\UniAlteriMangoPayExtension
 */
class UniAlteriMangoPayExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return UniAlteriMangoPayExtension
     */
    public function buildExtension()
    {
        return new UniAlteriMangoPayExtension();
    }

    public function testLoad()
    {
        $containerMock = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder', [], [], '', false);

        $containerMock->expects($this->atLeastOnce())->method('setParameter');
        $containerMock->expects($this->atLeastOnce())->method('setDefinition');

        $this->buildExtension()->load([], $containerMock);
    }
}
