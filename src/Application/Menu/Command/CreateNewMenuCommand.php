<?php

declare(strict_types=1);

namespace Task\Application\Menu\Command;

use Ramsey\Uuid\UuidInterface;

class CreateNewMenuCommand
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

    public function getMenuId(): UuidInterface
    {
        return $this->menuId;
    }

    public function getField(): string
    {
        return $this->field;
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
