<?php

namespace Beelab\SimplePageBundle\Tests\DependencyInjection;

use Beelab\SimplePageBundle\DependencyInjection\BeelabSimplePageExtension;
use PHPUnit_Framework_TestCase;

/**
 * @group unit
 */
class BeelabSimplePageExtensionTest extends PHPUnit_Framework_TestCase
{
    public function testLoadSetParameters()
    {
        $container = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')->disableOriginalConstructor()->getMock();
        $parameterBag = $this->getMockBuilder('Symfony\Component\DependencyInjection\ParameterBag\\ParameterBag')->disableOriginalConstructor()->getMock();

        $parameterBag->expects($this->any())->method('add');

        $container->expects($this->any())->method('getParameterBag')->will($this->returnValue($parameterBag));

        $extension = new BeelabSimplePageExtension();
        $configs = [
            ['page_class' => 'foo'],
            ['resources_prefix' => 'BarBundle:Dir:'],
        ];
        $extension->load($configs, $container);
    }
}
