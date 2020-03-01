<?php

declare(strict_types=1);

namespace Task\Infrastructure\Menu\Finder;

use Ramsey\Uuid\UuidInterface;
use Task\Infrastructure\Menu\Model\Menu;

class DbMenuFinder implements MenuFinder
{
    public function getByNodeId(UuidInterface $nodeId): Menu
    {
        // here finder is a part of infrastructure and should
        // return infrastructure model representation
        // to reconsider is part regarding recreation of children
        // - do it on db relations
        // - as recreation with subqueries
        // - here we can use redis as well to have quick access to current full
        // model state representation

        return Menu::fromArray();
    }
}
