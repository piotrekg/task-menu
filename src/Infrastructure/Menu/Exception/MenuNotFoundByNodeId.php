<?php

declare(strict_types=1);

namespace Task\Infrastructure\Menu\Exception;

use Ramsey\Uuid\UuidInterface;
use Task\Infrastructure\Common\Exception\InfrastructureNotFoundException;

class MenuNotFoundByNodeId extends InfrastructureNotFoundException
{
    private UuidInterface $nodeId;

    public function __construct(UuidInterface $nodeId)
    {
        $this->nodeId = $nodeId;

        parent::__construct(sprintf(
            'Menu not found by nodeId: %s',
            $nodeId->toString())
        );
    }

    public function getNodeId(): UuidInterface
    {
        return $this->nodeId;
    }
}
