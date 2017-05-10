<?php

declare(strict_types=1);

namespace CardBattleGame\Domain;

use CardBattleGame\Domain\Event\CardDealtForPlayerOnTurn;
use CardBattleGame\Domain\Event\CardPlayed;
use CardBattleGame\Domain\Event\GameCreated;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Ramsey\Uuid\Uuid;

final class Game extends AggregateRoot
{
    /**
     * @var Uuid
     */
    private $gameId;

    /**
     * @var Player
     */
    private $playerOnTurn;

    /**
     * @var Player
     */
    private $playerWaiting;

    /**
     * @var MovePoints
     */
    private $movePointsPerTurn;

    /**
     * @var Turn
     */
    private $turn;

    public static function create(Player $playerOnTurn, Player $playerWaiting, MovePoints $mp): Game
    {
        $gameId = Uuid::uuid4();
        $gameInstance = new self();

        $gameInstance->recordThat(GameCreated::occur(
            (string) $gameId, [
                'move-points' => $mp->getPointsCount(),
                'player-on-turn' => $playerOnTurn->asArray(),
                'player-waiting' => $playerWaiting->asArray(),
            ]
        ));

        return $gameInstance;
    }

    public function dealCardForPlayerOnTurn(Card $card): void
    {
        $this->recordThat(CardDealtForPlayerOnTurn::occur(
            $this->aggregateId(), [
                'player-on-turn' => $this->getPlayerOnTurn()->asArray(),
                'card' => $card->asArray(),
            ]
        ));
    }

    public function playCardByPlayerOnTurn(Card $card)
    {
        $this->recordThat(CardPlayed::occur(
            $this->aggregateId(), [
                'player-on-turn' => $this->getPlayerOnTurn()->asArray(),
                'card' => $card->asArray(),
            ]
        ));
    }

    public function getGameId() : Uuid
    {
        return $this->gameId;
    }

    public function getPlayerOnTurn(): Player
    {
        return $this->playerOnTurn;
    }

    public function getPlayerWaiting(): Player
    {
        return $this->playerWaiting;
    }

    public function getTurn(): Turn
    {
        return $this->turn;
    }

    protected function aggregateId(): string
    {
        return (string) $this->getGameId();
    }

    /**
     * Apply given event
     */
    protected function apply(AggregateChanged $event): void
    {
        switch (get_class($event)) {
            case GameCreated::class:
                /** @var GameCreated $event */
                $this->gameId = Uuid::fromString($event->aggregateId());
                $this->playerOnTurn = $event->getPlayerOnTurn();
                $this->playerWaiting = $event->getPlayerWaiting();
                $this->movePointsPerTurn = $event->getMovePoints();
                $this->turn = new Turn($this->playerOnTurn, $this->movePointsPerTurn);
                break;
            case CardDealtForPlayerOnTurn::class:
                /** @var CardDealtForPlayerOnTurn $event */
                $this->getPlayerOnTurn()->dealCard($event->getCard());
                break;
            case CardPlayed::class:
                /** @var CardPlayed $event */
                $card = $event->getCard();
                $this->getPlayerOnTurn()->playCard($card);
                $this->getPlayerWaiting()->takeDamage($card->getValue());
                $this->getTurn()->useMovePoints(new MovePoints($card->getMpCost()));
                break;
        }
    }
}
