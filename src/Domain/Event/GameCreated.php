<?php

declare(strict_types=1);

namespace CardBattleGame\Domain\Event;

use CardBattleGame\Domain\MovePoints;
use CardBattleGame\Domain\Player;
use Prooph\EventSourcing\AggregateChanged;

final class GameCreated extends AggregateChanged
{
    /**
     * @return Player
     */
    public function getPlayerOnTurn(): Player
    {
        return new Player(
            $this->payload['player-on-turn']['name'],
            $this->payload['player-on-turn']['hit-points']
        );
    }

    /**
     * @return Player
     */
    public function getPlayerWaiting(): Player
    {
        return new Player(
            $this->payload['player-waiting']['name'],
            $this->payload['player-waiting']['hit-points']
        );
    }

    /**
     * @return MovePoints
     */
    public function getMovePoints(): MovePoints
    {
        return new MovePoints($this->payload['move-points']);
    }
}
