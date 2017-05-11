<?php

namespace CardBattleGame\Application\Command;

use CardBattleGame\Domain\GameRepository;
use Interop\Container\ContainerInterface;

class CreateGameHandlerFactory
{
    public function __invoke(ContainerInterface $container): CreateGameHandler
    {
        $gameRepository = $container->get(GameRepository::class);

        return new CreateGameHandler($gameRepository);
    }
}
