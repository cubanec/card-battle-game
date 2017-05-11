<?php

namespace CardBattleGame\Application\Command;

use CardBattleGame\Domain\Card;
use CardBattleGame\Domain\GameRepository;
use Ramsey\Uuid\Uuid;

final class DealCardHandler
{
    private $games;

    public function __construct(GameRepository $games)
    {
        $this->games = $games;
    }


    public function __invoke(DealCard $command)
    {
        $gameId = Uuid::fromString($command->getGameId());

        $game = $this->games->get($gameId);

        $card = new Card($command->getType(), $command->getValue(), $command->getCost());

        $game->dealCardForPlayerOnTurn($card);

        $this->games->save($game);
    }
}