<?php

namespace CardBattleGame\Tests\Functional\Application;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use CardBattleGame\Tests\Functional\Domain\EventSourcedContextTrait;

final class CardsDealingContext implements Context
{
    use CqrsContextTrait;
    use EventSourcedContextTrait;

    /**
     * @Given player on the move was dealt with card of type :arg1 with value :arg2 and cost of :arg3 MP
     */
    public function playerOnTheMoveWasDealtWithCardOfTypeWithValueAndCostOfMp($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }

    /**
     * @When card of type :arg1 with value :arg2 HP and cost of :arg3 MP is dealt for player on turn
     */
    public function cardOfTypeWithValueHpAndCostOfMpIsDealtForPlayerOnTurn($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }

    /**
     * @Then player on turn has on hand card of type :arg1 with value :arg2 HP and cost of :arg3 MP
     */
    public function playerOnTurnHasOnHandCardOfTypeWithValueHpAndCostOfMp($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }
}
