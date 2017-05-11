<?php

namespace CardBattleGame\Tests\Functional\Domain;

use ArrayIterator;
use Assert\Assertion;
use Behat\Behat\Context\Context;
use CardBattleGame\Domain\Event\CardDealtForPlayerOnTurn;
use CardBattleGame\Domain\Event\GameCreated;
use Exception;

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

    /**
     * @Then player on turn has on hand card of type :arg1 with value :arg2 HP and cost of :arg3 MP
     */
    public function playerOnTurnHasOnHandCardOfTypeWithValueHpAndCostOfMp($arg1, $arg2, $arg3)
    {
        /** @var ArrayIterator $persistedEventStream */
        $persistedEventStream = $this->eventSourcedContext->getPersistedEventStream();

        foreach ($persistedEventStream as $event) {
            if ($event instanceof CardDealtForPlayerOnTurn) {
                /* @var $event CardDealtForPlayerOnTurn */
                var_dump($event->getCard());
                var_dump($arg1, $arg2, $arg3);
                if (
                    (string) $event->getCard()->getType() === $arg1
                    && $event->getCard()->getMpCost() === (int) $arg3
                    && $event->getCard()->getValue() === (int) $arg2
                ) {
                    return;
                }
            }
        }
        throw new Exception(sprintf("%s not found", CardDealtForPlayerOnTurn::class));
    }
}