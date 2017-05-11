<?php

namespace CardBattleGame\Infrastructure;

use CardBattleGame\Application\Command\CreateGameHandler;
use CardBattleGame\Application\Command\CreateGameHandlerFactory;
use CardBattleGame\Domain\GameRepository;
use Interop\Container\ContainerInterface;
use League\Container\Container as LeagueContainer;
use Prooph\EventStore\EventStore;

final class Container
{
    private static $container;

    public static function getInstance(): ContainerInterface
    {
        if (self::$container === null) {
            self::$container = self::initContainer(new LeagueContainer);
        }

        return self::$container;
    }

    private static function initContainer(LeagueContainer $container)
    {
        $container
            ->add(EventStore::class, new EventStoreFactory());

        $container
            ->add(GameRepository::class, new GameRepositoryImplFactory())
            ->withArgument($container);

        $container
            ->add(CreateGameHandler::class, new CreateGameHandlerFactory())
            ->withArgument($container);

        return $container;
    }
}
