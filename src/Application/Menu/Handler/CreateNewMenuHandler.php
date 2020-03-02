<?php

declare(strict_types=1);

namespace Task\Application\Menu\Handler;

use Task\Application\Common\Event\Dispatcher;
use Task\Application\Menu\Command\CreateNewMenuCommand;
use Task\Application\Menu\Exception\MenuWithMenuIdExists;
use Task\Domain\Menu\Event\NodeCreatedEvent;
use Task\Domain\Menu\Node;
use Task\Domain\Menu\Repository\NodeRepository;
use Task\Infrastructure\Menu\Exception\MenuNotFoundByNodeId;
use Task\Infrastructure\Menu\Finder\MenuFinder;

class CreateNewMenuHandler
{
    private MenuFinder $finder;

    private NodeRepository $repository;

    private Dispatcher $dispatcher;

    public function __construct(
        MenuFinder $finder,
        NodeRepository $repository,
        Dispatcher $dispatcher
    ) {
        $this->finder = $finder;
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @throws MenuWithMenuIdExists
     */
    public function __invoke(CreateNewMenuCommand $command): void
    {
        try {
            $this->finder->getByNodeId($command->getMenuId());

            throw new MenuWithMenuIdExists($command->getMenuId());
        } catch (MenuNotFoundByNodeId $e) {
            // menu not found as excepted
        }

        $this->repository->save(Node::create(
            $command->getMenuId(),
            $command->getField(),
            $command->getMaxDepth(),
            $command->getMaxChildren()
        ));

        $this->dispatcher->dispatch(new NodeCreatedEvent(
            $command->getMenuId(),
            $command->getField(),
            $command->getMaxDepth(),
            $command->getMaxChildren()
        ));
    }
}
