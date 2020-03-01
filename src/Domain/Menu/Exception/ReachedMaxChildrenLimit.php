<?php

declare(strict_types=1);

namespace Task\Domain\Menu\Exception;

use Ramsey\Uuid\UuidInterface;
use Task\Domain\Common\Exception\DomainAssertionException;

class ReachedMaxChildrenLimit extends DomainAssertionException
{
    private UuidInterface $nodeId;

    private int $maxChildren;

    public function __construct(UuidInterface $nodeId, int $maxChildren)
    {
        $this->nodeId = $nodeId;
        $this->maxChildren = $maxChildren;

        parent::__construct(sprintf(
            'Reached max children limit in node: %s, with limit: %d',
            $nodeId->toString(),
            $maxChildren
        ));
    }

    public function getNodeId(): UuidInterface
    {
        return $this->nodeId;
    }

    public function getMaxChildren(): int
    {
        return $this->maxChildren;
    }
}
