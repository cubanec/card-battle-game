<?php

namespace CardBattleGame\Tests\Functional\Domain;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use CardBattleGame\Domain\Card;
use CardBattleGame\Domain\Event\CardPlayed;

final class CardsPlayingContext implements Context
{
    use EventSourcedContextTrait;

    /**
     * @When player on the move plays the card of type :type with value :value and cost of :movePoints MP
     */
    public function playerOnTheMovePlaysTheCardOfTypeWithValueAndCostOfMp($type, $value, $movePoints)
    {
        $game = $this->eventSourcedContext->getAggregate();

        $game->playCardByPlayerOnTurn(new Card($type, $value, $movePoints));

        $this->eventSourcedContext->getGameRepository()->save($game);
    }

    /**
     * @Then card of type :type with value :value and cost of :movePoints MP was played
     */
    public function cardOfTypeWithValueAndCostOfMpWasPlayed($type, $value, $movePoints)
    {
        $card = new Card($type, $value, $movePoints);

        $event = CardPlayed::occur((string) $this->eventSourcedContext->getAggregateId(), [
            'card' => $card->asArray(),
        ]);

        Assertion::true($this->eventSourcedContext->hasAggregateRecordedEvent($event));
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