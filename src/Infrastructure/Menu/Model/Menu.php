<?php

declare(strict_types=1);

namespace Task\Infrastructure\Menu\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Menu
{
    private UuidInterface $menuId;

    private string $field;

    private int $maxDepth;

    private int $maxChildren;

    public function __construct(
        UuidInterface $menuId,
        string $field,
        int $maxDepth = 5,
        int $maxChildren = 5
    ) {
        $this->menuId = $menuId;
        $this->field = $field;
        $this->maxDepth = $maxDepth;
        $this->maxChildren = $maxChildren;
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            Uuid::fromString($payload['menuId']),
            $payload['field'],
            $payload['maxDepth'],
            $payload['maxChildren'],
        );
    }
}
