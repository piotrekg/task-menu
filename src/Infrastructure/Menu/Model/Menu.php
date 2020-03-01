<?php

declare(strict_types=1);

namespace Task\Infrastructure\Menu\Model;

class Menu
{
    public static function fromArray(): self
    {
        return new self();
    }
}
