<?php

namespace Beelab\SimplePageBundle\Tests\DependencyInjection;

use Beelab\SimplePageBundle\DependencyInjection\BeelabSimplePageExtension;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class BeelabSimplePageExtensionTest extends TestCase
{
    public function testLoadSetParameters(): void
    {
        $container = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')->disableOriginalConstructor()->getMock();

        $container->expects($this->exactly(3))->method('setParameter');

        $extension = new BeelabSimplePageExtension();
        $configs = [
            ['page_class' => 'foo'],
            ['resources_prefix' => 'BarBundle:Dir:'],
        ];
        $extension->load($configs, $container);
    }
}
