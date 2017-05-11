<?php

namespace CardBattleGame\Tests\Functional\Application;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use CardBattleGame\Domain\Game;
use CardBattleGame\Domain\MovePoints;
use CardBattleGame\Domain\Player;
use CardBattleGame\Tests\Functional\Domain\EventSourcedContextTrait;
use Ramsey\Uuid\Uuid;

class GameCreatingContext implements Context
{
    use CqrsContextTrait;
    use EventSourcedContextTrait;

    /**
     * @When new game is created with :movePoints MP per turn with :hitPoints HP per player
     */
    public function newGameIsCreatedWithMpPerTurnWithHpPerPlayer($mp, $hp)
    {
        throw new PendingException();

        $gameRepository = $this->eventSourcedContext->getGameRepository();

        //TODO: use $this->cqrsContext->getCommandRouter() to configure command routing

        //TODO: use $this->cqrsContext->getCommandBus()

        $persistedEventStream = $this->eventSourcedContext->getPersistedEventStream();
        $this->eventSourcedContext->setAggregateId(Uuid::fromString($persistedEventStream->current()->aggregateId()));
    }

    /**
     * @Given game was created with :movePoints MP per turn with :hitPoints HP per player
     */
    public function gameWasCreatedWithMpPerTurnWithHpPerPlayer($movePoints, $hitPoints)
    {
        $playerOnTurn = new Player('player1', (int) $hitPoints);
        $playerWaiting = new Player('player2', (int) $hitPoints);

        $game = Game::create($playerOnTurn, $playerWaiting, new MovePoints((int) $movePoints));

        $this->eventSourcedContext->setAggregateId($game->getGameId());
        $this->eventSourcedContext->getGameRepository()->save($game);
    }
}
