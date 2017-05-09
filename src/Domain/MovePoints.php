<?php

declare(strict_types=1);

namespace CardBattleGame\Domain;

final class MovePoints
{
    /**
     * @var int
     */
    private $pointsCount;

    public function __construct(int $pointsCount)
    {
        if ($pointsCount < 0) {
            throw new \DomainException('points count has to be positive');
        }

        $this->pointsCount = $pointsCount;
    }

    /**
     * @return int
     */
    public function getPointsCount(): int
    {
        return $this->pointsCount;
    }
}
