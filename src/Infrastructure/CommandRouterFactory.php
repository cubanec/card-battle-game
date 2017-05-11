<?php

namespace CardBattleGame\Infrastructure;

use CardBattleGame\Application\Command\CreateGame;
use CardBattleGame\Application\Command\CreateGameHandler;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;

final class CommandRouterFactory
{
    public static function create(): CommandRouter
    {
        $router = new CommandRouter();

        $router
            ->route(CreateGame::class)
            ->to(CreateGameHandler::class);

        return $router;
    }
}
