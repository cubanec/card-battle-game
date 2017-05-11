<?php

namespace CardBattleGame\Application\Command;

final class DealCard
{
    private $gameId;
    private $type;
    private $cost;
    private $value;

    public function __construct(string $gameId, string $type, int $cost, int $value)
    {
        $this->gameId = $gameId;
        $this->type   = $type;
        $this->cost   = $cost;
        $this->value  = $value;
    }

    public function getGameId(): string
    {
        return $this->gameId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}