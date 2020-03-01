<?php

declare(strict_types=1);

namespace Task\Infrastructure\Menu\Finder;

use Ramsey\Uuid\UuidInterface;
use Task\Infrastructure\Menu\Exception\MenuNotFoundByNodeId;
use Task\Infrastructure\Menu\Model\Menu;

interface MenuFinder
{
    /**
     * @throws MenuNotFoundByNodeId
     */
    public function getByNodeId(UuidInterface $nodeId): Menu;
}
