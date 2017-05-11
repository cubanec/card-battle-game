<?php

namespace CardBattleGame\Tests\Functional\Domain;

use Behat\Behat\Context\Context;
use CardBattleGame\Domain\Game;
use CardBattleGame\Domain\MovePoints;
use CardBattleGame\Domain\Player;

final class GameCreatingContext implements Context
{
    use EventSourcedContextTrait;

    /**
     * @Given game was created with :movePoints MP per turn with :hitPoints HP per player
     * @When new game is created with :movePoints MP per turn with :hitPoints HP per player
     */
    public function newGameIsCreatedWithMpPerTurnWithHpPerPlayer($movePoints, $hitPoints)
    {
        $playerOnTurn = new Player('player1', (int) $hitPoints);
        $playerWaiting = new Player('player2', (int) $hitPoints);

        $game = Game::create($playerOnTurn, $playerWaiting, new MovePoints((int) $movePoints));

        $this->eventSourcedContext->setAggregateId($game->getGameId());
        $this->eventSourcedContext->getGameRepository()->save($game);
    }
}
