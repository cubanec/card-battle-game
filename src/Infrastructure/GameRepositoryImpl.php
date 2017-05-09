<?php

declare(strict_types=1);

namespace CardBattleGame\Infrastructure;

use CardBattleGame\Domain\Game;
use CardBattleGame\Domain\GameRepository;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;
use Ramsey\Uuid\Uuid;

class GameRepositoryImpl extends AggregateRepository implements GameRepository
{
    public function __construct(EventStore $eventStore)
    {
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass(Game::class),
            new AggregateTranslator(),
            null,
            null,
            false
        );
    }

    public function save(Game $game): void
    {
        $this->saveAggregateRoot($game);
    }

    public function get(Uuid $gameId): ?Game
    {
        return $this->getAggregateRoot((string) $gameId);
    }
}
