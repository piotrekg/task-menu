<?php

declare(strict_types=1);

namespace Task\Domain\Menu\Exception;

use Ramsey\Uuid\UuidInterface;
use Task\Domain\Common\Exception\DomainAssertionException;

class ReachedMaxDepthLimit extends DomainAssertionException
{
    private UuidInterface $nodeId;

    private int $maxDepth;

    public function __construct(UuidInterface $nodeId, int $maxDepth)
    {
        $this->nodeId = $nodeId;
        $this->maxDepth = $maxDepth;

        parent::__construct(sprintf(
            'Reached max depth limit in node: %s, with limit: %d',
            $nodeId->toString(),
            $maxDepth
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
