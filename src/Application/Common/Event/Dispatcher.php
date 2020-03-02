<?php

declare(strict_types=1);

namespace Task\Application\Common\Event;

interface Dispatcher
{
    public function dispatch(object $event): void;
}
