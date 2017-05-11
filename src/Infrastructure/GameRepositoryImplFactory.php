<?php

namespace CardBattleGame\Infrastructure;

use Interop\Container\ContainerInterface;
use Prooph\EventStore\EventStore;

class GameRepositoryImplFactory
{
    public function __invoke(ContainerInterface $container): GameRepositoryImpl
    {
        $eventStore = $container->get(EventStore::class);

        return new GameRepositoryImpl($eventStore);
    }
}
