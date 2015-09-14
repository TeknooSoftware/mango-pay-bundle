<?php

namespace UniAlteri\MangoPayBundle\Tests\DependencyInjection;

use UniAlteri\MangoPayBundle\DependencyInjection\Configuration;

/**
 * Class ConfigurationTest
 * @package UniAlteri\MangoPayBundle\Tests\DependencyInjection
 * @covers UniAlteri\MangoPayBundle\DependencyInjection\Configuration
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Configuration
     */
    public function buildConfiguration()
    {
        return new Configuration();
    }

    public function testGetConfigTreeBuilder()
    {
        $configuration = $this->buildConfiguration();
        $treeBuilder = $configuration->getConfigTreeBuilder();

        $this->assertInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder', $treeBuilder);
    }
}
