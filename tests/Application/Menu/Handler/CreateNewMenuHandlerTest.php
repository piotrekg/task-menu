<?php

declare(strict_types=1);

namespace Tests\Application\Menu\Handler;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Task\Application\Common\Event\Dispatcher;
use Task\Application\Common\Event\MockDispatcher;
use Task\Application\Menu\Command\CreateNewMenuCommand;
use Task\Application\Menu\Exception\MenuWithMenuIdExists;
use Task\Application\Menu\Handler\CreateNewMenuHandler;
use Task\Domain\Menu\Event\NodeCreatedEvent;
use Task\Domain\Menu\Node;
use Task\Domain\Menu\Repository\NodeRepository;
use Task\Infrastructure\Menu\Exception\MenuNotFoundByNodeId;
use Task\Infrastructure\Menu\Finder\MenuFinder;
use Task\Infrastructure\Menu\Model\Menu;

class CreateNewMenuHandlerTest extends TestCase
{
    private MenuFinder $finder;

    private NodeRepository $repository;

    private Dispatcher $dispatcher;

    public function setUp(): void
    {
        $this->finder = $this->createMock(MenuFinder::class);
        $this->repository = $this->createMock(NodeRepository::class);
        $this->dispatcher = new MockDispatcher();
    }

    public function testSuccess(): void
    {
        // given
        $node = Node::create(
            Uuid::uuid4(),
            'Test one',
            5,
            5
        );

        $command = new CreateNewMenuCommand(
            $node->nodeId(),
            $node->name(),
            $node->maxDepth(),
            $node->maxChildren()
        );

        $this
            ->finder
            ->method('getByNodeId')
            ->with($node->nodeId())
            ->willThrowException(new MenuNotFoundByNodeId($node->nodeId()));

        $this->repository->method('save')->with($node);

        $handler = new CreateNewMenuHandler(
            $this->finder,
            $this->repository,
            $this->dispatcher
        );

        // when
        $handler($command);

        // then
        $events = $this->dispatcher->getEvents();
        /** @var NodeCreatedEvent $event */
        $event = $events[0];
        $this->assertCount(1, $events);
        $this->assertEquals($node->nodeId()->toString(), $event->getNodeId()->toString());
        $this->assertEquals($node->name(), $event->getName());
        $this->assertEquals($node->maxDepth(), $event->getMaxDepth());
        $this->assertEquals($node->maxChildren(), $event->getMaxChildren());
    }

    public function testConflict(): void
    {
        // given
        $node = Node::create(
            Uuid::uuid4(),
            'Test one',
            5,
            5
        );

        $command = new CreateNewMenuCommand(
            $node->nodeId(),
            $node->name(),
            $node->maxDepth(),
            $node->maxChildren()
        );

        $this
            ->finder
            ->method('getByNodeId')
            ->with($node->nodeId())
            ->willReturn(new Menu(
                $node->nodeId(),
                $node->name(),
                $node->maxDepth(),
                $node->maxChildren()
            ));

        $this->repository->method('save')->with($node);

        $handler = new CreateNewMenuHandler(
            $this->finder,
            $this->repository,
            $this->dispatcher
        );

        // then
        $this->expectException(MenuWithMenuIdExists::class);

        // when
        $handler($command);
    }
}
