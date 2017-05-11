<?php

namespace CardBattleGame\Tests\Functional\Domain;

use ArrayIterator;
use Assert\Assertion;
use Behat\Behat\Context\Context;
use CardBattleGame\Domain\Card;
use CardBattleGame\Domain\Event\CardDealtForPlayerOnTurn;
use CardBattleGame\Domain\Event\GameCreated;

final class CardsDealingContext implements Context
{
    use EventSourcedContextTrait;

    /**
     * @Given player on the move was dealt with card of type :type with value :value and cost of :movePoints MP
     * @When card of type :type with value :value HP and cost of :cost MP is dealt for player on turn
     */
    public function cardOfTypeWithValueHpAndCostOfMpIsDealtForPlayerOnTurn($type, $value, $cost)
    {
        $game = $this->eventSourcedContext->getAggregate();

        $game->dealCardForPlayerOnTurn(new Card($type, (int) $value, (int) $cost));

        $this->eventSourcedContext->getGameRepository()->save($game);
    }
}
