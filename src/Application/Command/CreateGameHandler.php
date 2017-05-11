<?php

namespace CardBattleGame\Application\Command;

use CardBattleGame\Domain\Game;
use CardBattleGame\Domain\GameRepository;
use CardBattleGame\Domain\MovePoints;
use CardBattleGame\Domain\Player;

final class CreateGameHandler
{
    private $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function handle(CreateGame $createGameCommand): void
    {
        $playerOnTurn = new Player(
            $createGameCommand->getPlayerOnTurnName(),
            $createGameCommand->getHitPointsPerPlayer()
        );
        $playerWaiting = new Player(
            $createGameCommand->getPlayerWaitingName(),
            $createGameCommand->getHitPointsPerPlayer()
        );

        $newGame = Game::create(
            $playerOnTurn,
            $playerWaiting,
            new MovePoints($createGameCommand->getMovePointsPerTurn())
        );

        $this->gameRepository->save($newGame);
    }
}
