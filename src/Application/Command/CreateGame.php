<?php

declare(strict_types=1);

namespace CardBattleGame\Application\Command;

use Prooph\Common\Messaging\Command;

final class CreateGame extends Command
{
    private $playerOnTurnName;
    private $playerWaitingName;
    private $hitPointsPerPlayer;
    private $movePointsPerTurn;

    public function __construct(
        string $playerOnTurnName,
        string $playerWaitingName,
        int $hitPointsPerPlayer,
        int $movePointsPerTurn
    ) {
        $this->playerOnTurnName = $playerOnTurnName;
        $this->playerWaitingName = $playerWaitingName;
        $this->hitPointsPerPlayer = $hitPointsPerPlayer;
        $this->movePointsPerTurn = $movePointsPerTurn;

        $this->init();
    }

    public function getPlayerOnTurnName(): string
    {
        return $this->playerOnTurnName;
    }

    public function getPlayerWaitingName(): string
    {
        return $this->playerWaitingName;
    }

    public function getHitPointsPerPlayer(): int
    {
        return $this->hitPointsPerPlayer;
    }

    public function getMovePointsPerTurn(): int
    {
        return $this->movePointsPerTurn;
    }

    public function payload(): array
    {
        return [
            'player-on-turn-name' => $this->getPlayerOnTurnName(),
            'player-waiting-name' => $this->getPlayerWaitingName(),
            'hit-points-per-player' => $this->getHitPointsPerPlayer(),
            'move-points-per-turn' => $this->getMovePointsPerTurn(),
        ];
    }

    protected function setPayload(array $payload): void
    {
        $this->playerOnTurnName = $payload['player-on-turn-name'];
        $this->playerWaitingName = $payload['player-waiting-name'];
        $this->hitPointsPerPlayer = $payload['hit-points-per-player'];
        $this->movePointsPerTurn = $payload['move-points-per-turn'];
    }
}
