<?php

namespace CardBattleGame\Infrastructure;

use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\EventStore\InMemoryEventStore;
use Prooph\EventStore\TransactionalActionEventEmitterEventStore;

class EventStoreFactory
{
    public function __invoke()
    {
        return new TransactionalActionEventEmitterEventStore(
            new InMemoryEventStore(),
            new ProophActionEventEmitter()
        );
    }
}
