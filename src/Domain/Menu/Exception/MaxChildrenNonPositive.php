<?php

declare(strict_types=1);

namespace Task\Domain\Menu\Exception;

use Ramsey\Uuid\UuidInterface;
use Task\Domain\Common\Exception\DomainAssertionException;

class MaxChildrenNonPositive extends DomainAssertionException
{
    private UuidInterface $nodeId;

    private int $maxChildren;

    public function __construct(UuidInterface $nodeId, int $maxChildren)
    {
        $this->nodeId = $nodeId;
        $this->maxChildren = $maxChildren;

        parent::__construct(sprintf(
            'Max children must be greater than zero in node: %s',
            $nodeId->toString()
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
