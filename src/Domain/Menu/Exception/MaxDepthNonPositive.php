<?php

declare(strict_types=1);

namespace Task\Domain\Menu\Exception;

use Ramsey\Uuid\UuidInterface;
use Task\Domain\Common\Exception\DomainAssertionException;

class MaxDepthNonPositive extends DomainAssertionException
{
    private UuidInterface $nodeId;

    private int $maxDepth;

    public function __construct(UuidInterface $nodeId, int $maxChildren)
    {
        $this->nodeId = $nodeId;
        $this->maxDepth = $maxChildren;

        parent::__construct(sprintf(
            'Max depth must be greater than zero in node: %s',
            $nodeId->toString()
        ));
    }

    public function getNodeId(): UuidInterface
    {
        return $this->nodeId;
    }

    public function getMaxDepth(): int
    {
        return $this->maxDepth;
    }
}
