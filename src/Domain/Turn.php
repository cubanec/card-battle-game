<?php

declare(strict_types=1);

namespace CardBattleGame\Domain;

final class Turn
{
    /**
     * @var Player
     */
    private $player;
    /**
     * @var MovePoints
     */
    private $movePoints;

    public function __construct(Player $player, MovePoints $movePoints)
    {
        $this->player = $player;
        $this->movePoints = $movePoints;
    }

    public function useMovePoints(MovePoints $movePoints)
    {
        $this->movePoints = new MovePoints($this->movePoints->getPointsCount() - $movePoints->getPointsCount());
    }

    public function getMovePoints(): MovePoints
    {
        return $this->movePoints;
    }
}
