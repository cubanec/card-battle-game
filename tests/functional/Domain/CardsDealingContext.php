<?php

namespace CardBattleGame\Tests\Functional\Domain;

use ArrayIterator;
use Behat\Behat\Context\Context;
use CardBattleGame\Domain\Card;
use CardBattleGame\Domain\Event\CardDealtForPlayerOnTurn;
use CardBattleGame\Domain\Event\GameCreated;
use Webmozart\Assert\Assert;

final class CardsDealingContext implements Context
{
    use EventSourcedContextTrait;

    /**
     * @When card of type :type with value :value HP and cost of :cost MP is dealt for player on turn
     */
    public function cardOfTypeWithValueHpAndCostOfMpIsDealtForPlayerOnTurn($type, $value, $cost)
    {
        $game = $this->eventSourcedContext->getAggregate();

        $game->dealCardForPlayerOnTurn(new Card($type, (int) $value, (int) $cost));

        $this->eventSourcedContext->getGameRepository()->save($game);
    }

    /**
     * @Then player on turn has on hand card of type :arg1 with value :arg2 HP and cost of :arg3 MP
     */
    public function playerOnTurnHasOnHandCardOfTypeWithValueHpAndCostOfMp($arg1, $arg2, $arg3)
    {
        /** @var ArrayIterator $persistedEventStream */
        $persistedEventStream = $this->eventSourcedContext->getPersistedEventStream();

        Assert::isInstanceOf($persistedEventStream->current(), GameCreated::class);
        $persistedEventStream->next();
        Assert::isInstanceOf($persistedEventStream->current(), CardDealtForPlayerOnTurn::class);
    }
}
