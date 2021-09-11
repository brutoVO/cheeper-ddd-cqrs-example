<?php

declare(strict_types=1);

namespace Cheeper\Chapter6\Infrastructure\Application\Event;

use Cheeper\Chapter6\Application\Event\EventBus;
use Cheeper\DomainModel\DomainEvent;

//snippet in-memory-event-bus
final class InMemoryEventBus implements EventBus
{
    public function __construct(
        private array $events = []
    )
    {
    }

    public function events(): array
    {
        return $this->events;
    }

    public function reset(): void
    {
        $this->events = [];
    }

    public function notify(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    public function notifyAll(array $domainEvents): void
    {
        \Functional\each($domainEvents, fn ($de) => $this->notify($de));
    }
}
//end-snippet