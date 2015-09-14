<?php

namespace UniAlteri\MangoPayBundle\Tests\DependencyInjection;

use UniAlteri\MangoPayBundle\DependencyInjection\UniAlteriMangoPayExtension;

/**
 * Class UniAlteriMangoPayExtensionTest
 * @package UniAlteri\MangoPayBundle\Tests\DependencyInjection
 * @covers UniAlteri\MangoPayBundle\DependencyInjection\UniAlteriMangoPayExtension
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
