<?php

namespace CardBattleGame\Domain\Event;

use CardBattleGame\Domain\Card;
use Prooph\EventSourcing\AggregateChanged;

final class CardDealtForPlayerOnTurn extends AggregateChanged
{
    /**
     * @return Card
     */
    public function getCard(): Card
    {
        return new Card(
            $this->payload['type'],
            $this->payload['value'],
            $this->payload['move-points']
        );
    }
}
