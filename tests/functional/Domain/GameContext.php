<?php

namespace CardBattleGame\Tests\Functional\Domain;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use CardBattleGame\Domain\Event\GameCreated;

class GameContext implements Context
{
    use EventSourcedContextTrait;

    /**
     * @Then the game should be created
     */
    public function theGameShouldBeCreated()
    {
        $persistedEventStream = $this->eventSourcedContext->getPersistedEventStream();

        Assertion::isInstanceOf($persistedEventStream->current(), GameCreated::class);
    }

    /**
     * @Then player waiting has :hitPoints HP left
     */
    public function playerWaitingHasHpLeft($hitPoints)
    {
        $game = $this->eventSourcedContext->getAggregate();

        Assertion::same($game->getPlayerWaiting()->getHitPoints(), (int) $hitPoints);
    }

    /**
     * @Then player on the move has :movePoints MP left
     */
    public function playerOnTheMoveHasMpLeft($movePoints)
    {
        $game = $this->eventSourcedContext->getAggregate();

        Assertion::same($game->getTurn()->getMovePoints()->getPointsCount(), (int) $movePoints);
    }

    /**
     * @Then player on turn has :hitPoints HP left
     */
    public function playerOnTurnHasHpLeft($hitPoints)
    {
        $game = $this->eventSourcedContext->getAggregate();

        Assertion::same($game->getPlayerOnTurn()->getHitPoints(), (int) $hitPoints);
    }
}