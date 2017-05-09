<?php

namespace CardBattleGame\Tests\Functional\Domain;

use Behat\Behat\Context\Context;
use CardBattleGame\Domain\Event\GameCreated;
use CardBattleGame\Domain\Game;
use CardBattleGame\Domain\MovePoints;
use CardBattleGame\Domain\Player;
use Webmozart\Assert\Assert;

final class GameCreatingContext implements Context
{
    use EventSourcedContextTrait;

    /**
     * @Given new game is created with :movePoints MP per turn with :hitPoints HP per player
     */
    public function newGameIsCreatedWithMpPerTurnWithHpPerPlayer($movePoints, $hitPoints)
    {
        $playerOnTurn = new Player('player1', (int) $hitPoints);
        $playerWaiting = new Player('player2', (int) $hitPoints);

        $game = Game::create($playerOnTurn, $playerWaiting, new MovePoints((int) $movePoints));

        $this->eventSourcedContext->setAggregateId($game->getGameId());
        $this->eventSourcedContext->getGameRepository()->save($game);
    }

    /**
     * @Then the game should be created
     */
    public function theGameShouldBeCreated()
    {
        $persistedEventStream = $this->eventSourcedContext->getPersistedEventStream();

        Assert::isInstanceOf($persistedEventStream->current(), GameCreated::class);
    }
}
