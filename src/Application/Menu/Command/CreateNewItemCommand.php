<?php

declare(strict_types=1);

namespace Task\Application\Menu\Command;

use Ramsey\Uuid\UuidInterface;

class CreateNewItemCommand
{
    private UuidInterface $itemId;

    private UuidInterface $menuId;

    private string $field;

    private int $maxDepth;

    private int $maxChildren;

    public function __construct(
        UuidInterface $itemId,
        UuidInterface $menuId,
        string $field,
        int $maxDepth = 5,
        int $maxChildren = 5
    ) {
        $this->itemId = $itemId;
        $this->menuId = $menuId;
        $this->field = $field;
        $this->maxDepth = $maxDepth;
        $this->maxChildren = $maxChildren;
    }

    public function getItemId(): UuidInterface
    {
        return $this->itemId;
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
