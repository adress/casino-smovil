<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Bus\Event\InMemory;

use Illuminate\Support\Facades\Event;
use Src\Shared\Domain\Bus\Event\DomainEvent;
use Src\Shared\Domain\Bus\Event\EventBus;

class LaravelEventBus implements EventBus
{
  public function publish(DomainEvent ...$events): void
  {
    foreach ($events as $event) {
      Event::dispatch($event);
    }
  }
}
