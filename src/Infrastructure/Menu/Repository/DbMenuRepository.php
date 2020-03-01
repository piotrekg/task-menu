<?php

declare(strict_types=1);

namespace Task\Infrastructure\Menu\Repository;

use Illuminate\Database\Connection;
use Ramsey\Uuid\UuidInterface;
use Task\Domain\Menu\Node;
use Task\Domain\Menu\Repository\NodeRepository;
use Task\Infrastructure\Menu\Exception\MenuNotFoundByNodeId;
use Task\Infrastructure\Menu\Finder\MenuFinder;

class DbMenuRepository implements NodeRepository
{
    private Connection $connection;

    private MenuFinder $finder;

    public function __construct(
        Connection $connection,
        MenuFinder $finder
    ) {
        $this->connection = $connection;
        $this->finder = $finder;
    }

    public function save(Node $node): void
    {
        // save in db, tbh, here i'll use nosql storage like mongo
        // to store document with children ids as map
    }

    /**
     * @throws MenuNotFoundByNodeId
     */
    public function delete(UuidInterface $nodeId): void
    {
        // try to find node, if not exists throw exception
        // if ok, delete element
    }
}
