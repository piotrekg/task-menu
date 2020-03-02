<?php

declare(strict_types=1);

namespace Task\Application\Common\Event;

class MockDispatcher implements Dispatcher
{
    protected array $events;

    public function __construct()
    {
        $this->events = [];
    }

    public function dispatch(object $event): void
    {
        $this->events[] = $event;
    }

    public function getEvents(): array
    {
        return $this->events;
    }
}
