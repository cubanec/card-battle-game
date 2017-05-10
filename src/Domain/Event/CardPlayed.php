<?php

namespace CardBattleGame\Domain\Event;

use CardBattleGame\Domain\Card;
use Prooph\EventSourcing\AggregateChanged;

final class CardPlayed extends AggregateChanged
{
    public function getCard(): Card
    {
        return new Card(
            $this->payload['card']['type'],
            $this->payload['card']['value'],
            $this->payload['card']['move-points']
        );
    }
}
