<?php

declare(strict_types=1);

namespace Task\Application\Menu\Exception;

// should extends application layer exception
use Ramsey\Uuid\UuidInterface;

class MenuWithMenuIdExists extends \InvalidArgumentException
{
    public function __construct(UuidInterface $menuId)
    {
        parent::__construct();
    }
}
