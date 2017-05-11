<?php

namespace CardBattleGame\Tests\Functional\Application;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use CardBattleGame\Tests\Functional\Domain\EventSourcedContextTrait;

final class CardsPlayingContext implements Context
{
    use CqrsContextTrait;
    use EventSourcedContextTrait;

    /**
     * @When player on the move plays the card of type :arg1 with value :arg2 and cost of :arg3 MP
     */
    public function playerOnTheMovePlaysTheCardOfTypeWithValueAndCostOfMp($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }

    /**
     * @Then card of type :arg1 with value :arg2 and cost of :arg3 MP was played
     */
    public function cardOfTypeWithValueAndCostOfMpWasPlayed($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }
}
