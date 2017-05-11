<?php

namespace CardBattleGame\Tests\Functional\Domain;

use ArrayIterator;
use Behat\Behat\Context\Context;
use CardBattleGame\Domain\Event\CardPlayed;
use CardBattleGame\Domain\Game;
use CardBattleGame\Domain\GameRepository;
use CardBattleGame\Infrastructure\Container;
use CardBattleGame\Infrastructure\GameRepositoryImpl;
use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\Common\Messaging\DomainEvent;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventStore\EventStore;
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

    public function getGameRepository(): GameRepository
    {
        return $this->gameRepository;
    }

    public function getPersistedEventStream(): \Iterator
    {
        return $this->eventStore->load(
            $this->singleStream->streamName()
        );
    }

    public function getAggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    public function setAggregateId(Uuid $aggregateId)
    {
        $this->aggregateId = $aggregateId;
    }

    public function getAggregate(): ?Game
    {
        return $this->getGameRepository()->get($this->getAggregateId());
    }

    public function appendEvent(AggregateChanged $domainEvent): void
    {
        $this->eventStore->appendTo(
            $this->singleStream->streamName(),
            new \IteratorIterator(new \ArrayObject([$domainEvent]))
        );
    }

    public function hasAggregateRecordedEvent(AggregateChanged $event)
    {
        $eventStream = $this->getPersistedEventStream();
        foreach ($eventStream as $persistedEvent) {
            switch (get_class($persistedEvent)) {
                case CardPlayed::class:
                    return get_class($event) === CardPlayed::class
                        && $event->getCard()->equals($persistedEvent->getCard());
            }
        }
    }
}
