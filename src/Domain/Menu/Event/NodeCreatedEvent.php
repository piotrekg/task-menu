<?php

declare(strict_types=1);

namespace Task\Domain\Menu\Event;

use Ramsey\Uuid\UuidInterface;

class NodeCreatedEvent
{
    private UuidInterface $nodeId;

    private string $name;

    private int $maxDepth;

    private int $maxChildren;

    public function __construct(
        UuidInterface $nodeId,
        string $name,
        int $maxDepth = 5,
        int $maxChildren = 5
    ) {
        $this->nodeId = $nodeId;
        $this->name = $name;
        $this->maxDepth = $maxDepth;
        $this->maxChildren = $maxChildren;
    }

    public function getNodeId(): UuidInterface
    {
        return $this->nodeId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxDepth(): int
    {
        return $this->maxDepth;
    }

    public function getMaxChildren(): int
    {
        return $this->maxChildren;
    }
}
