<?php

namespace CardBattleGame\Tests\Functional\Domain;

use ArrayIterator;
use Behat\Behat\Context\Context;
use CardBattleGame\Domain\Game;
use CardBattleGame\Domain\GameRepository;
use CardBattleGame\Infrastructure\GameRepositoryImpl;
use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\EventStore\InMemoryEventStore;
use Prooph\EventStore\Stream;
use Prooph\EventStore\StreamName;
use Prooph\EventStore\TransactionalActionEventEmitterEventStore;
use Ramsey\Uuid\Uuid;

final class EventSourcedContext implements Context
{
    /**
     * @var Uuid
     */
    private $aggregateId;

    /**
     * @var TransactionalActionEventEmitterEventStore
     */
    private $eventStore;

    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * @var Stream
     */
    private $singleStream;

    public function __construct()
    {
        $this->eventStore = new TransactionalActionEventEmitterEventStore(
            new InMemoryEventStore(),
            new ProophActionEventEmitter()
        );

        $streamName = new StreamName('event_stream');
        $this->singleStream = new Stream($streamName, new ArrayIterator());

        $this->eventStore->create($this->singleStream);

        $this->gameRepository = new GameRepositoryImpl($this->eventStore);
    }

    /**
     * @return GameRepository
     */
    public function getGameRepository(): GameRepository
    {
        return $this->gameRepository;
    }

    /**
     * @return \Iterator
     */
    public function getPersistedEventStream(): \Iterator
    {
        return $this->eventStore->load(
            $this->singleStream->streamName()
        );
    }

    /**
     * @return Uuid
     */
    public function getAggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    /**
     * @param Uuid $aggregateId
     */
    public function setAggregateId(Uuid $aggregateId)
    {
        $this->aggregateId = $aggregateId;
    }

    public function getAggregate(): ?Game
    {
        return $this->getGameRepository()->get($this->getAggregateId());
    }
}