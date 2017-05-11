<?php

namespace CardBattleGame\Tests\Functional\Application;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use CardBattleGame\Application\Command\DealCard;
use CardBattleGame\Application\Command\DealCardHandler;
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
        $id = $this->eventSourcedContext->getAggregateId();

        $games = $this->eventSourcedContext->getGameRepository();

        $command = new DealCard((string) $id, $arg1, $arg2, $arg3);

        $handler = new DealCardHandler($games);

        $this->getCqrsContext()->getCommandRouter()->route(DealCard::class)->to($handler);

        $this->getCqrsContext()->getCommandBus()->dispatch($command);
    }
}
