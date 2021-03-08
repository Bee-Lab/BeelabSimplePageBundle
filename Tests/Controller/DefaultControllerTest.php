<?php

namespace Beelab\SimplePageBundle\Tests\Controller;

use Beelab\SimplePageBundle\Controller\DefaultController;
use Beelab\SimplePageBundle\Entity\Page;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

final class DefaultControllerTest extends TestCase
{
    /**
     * @var DefaultController
     */
    private $controller;

    /**
     * @var ContainerInterface&\PHPUnit\Framework\MockObject\MockObject
     */
    private $container;

    /**
     * @var ManagerRegistry&\PHPUnit\Framework\MockObject\MockObject
     */
    private $doctrine;

    /**
     * @var Environment&\PHPUnit\Framework\MockObject\MockObject
     */
    private $twig;

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
        $this->doctrine = $this->createMock(ManagerRegistry::class);
        $this->twig = $this->createMock(Environment::class);
        $this->controller = new DefaultController($this->doctrine, $this->twig, 'foo', 'bar');
    }

    public function testShowActionPageNotFound(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $repo = $this->createMock(EntityRepository::class);

        $this->doctrine
            ->expects(self::once())
            ->method('getRepository')
            ->with('foo')
            ->willReturn($repo)
        ;

        $this->controller->showAction('baz');
    }

    public function testShowAction(): void
    {
        $page = $this->createMock(Page::class);

        $repo = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->addMethods(['findOneByPath'])
            ->getMock()
        ;

        $this->doctrine
            ->expects(self::once())
            ->method('getRepository')
            ->with('foo')
            ->willReturn($repo)
        ;

        $repo
            ->expects(self::once())
            ->method('findOneByPath')
            ->with('foo')
            ->willReturn($page)
        ;

        $this->twig
            ->method('render')
            ->willReturn('html content...')
        ;

        $this->controller->showAction('foo');
    }
}
