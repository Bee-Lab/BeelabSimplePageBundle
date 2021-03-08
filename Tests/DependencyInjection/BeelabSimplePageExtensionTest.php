<?php

namespace Beelab\SimplePageBundle\Tests\DependencyInjection;

use Beelab\SimplePageBundle\DependencyInjection\BeelabSimplePageExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @group unit
 */
final class BeelabSimplePageExtensionTest extends TestCase
{
    public function testLoadSetParameters(): void
    {
        /**
         * @var ContainerBuilder&\PHPUnit\Framework\MockObject\MockObject
         */
        $container = $this->getMockBuilder(ContainerBuilder::class)->disableOriginalConstructor()->getMock();

        $container->expects($this->exactly(3))->method('setParameter');

        $extension = new BeelabSimplePageExtension();
        $configs = [
            ['page_class' => 'foo'],
            ['resources_prefix' => 'BarBundle:Dir:'],
        ];
        $extension->load($configs, $container);
    }
}
