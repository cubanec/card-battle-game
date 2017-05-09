<?php

declare(strict_types=1);

namespace CardBattleGame\Domain;

use Ramsey\Uuid\Uuid;

interface GameRepository
{
    public function get(Uuid $gameId): ?Game;
    public function save(Game $game): void;
}
