<?php

declare(strict_types=1);

namespace Task\Domain\Menu\Repository;

use Ramsey\Uuid\UuidInterface;
use Task\Domain\Menu\Node;

interface NodeRepository
{
    public function save(Node $node): void;

    public function delete(UuidInterface $nodeId): void;
}
