<?php

declare(strict_types=1);

namespace CardBattleGame\Domain;

final class Player
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $hitPoints;

    /**
     * @var Card[]
     */
    private $hand = [];

    public function __construct(string $name, int $hitPoints)
    {
        $this->name = $name;
        $this->hitPoints = $hitPoints;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getHitPoints(): int
    {
        return $this->hitPoints;
    }

    public function takeDamage(int $hitPoints): void
    {
        $this->hitPoints -= $hitPoints;
    }

    /**
     * @return Card[]
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    public function dealCard(Card $card)
    {
        $this->hand[] = $card;
    }

    public function playCard(Card $selectedCard): void
    {
        foreach ($this->getHand() as $cardOnHandKey => $cardOnHand) {
            if ($cardOnHand->equals($selectedCard)) {
                unset($this->hand[$cardOnHandKey]);
                return;
            }
        }
        throw new \DomainException('selected card is not on players hand');
    }

    public function asArray(): array
    {
        return [
            'name' => $this->getName(),
            'hit-points' => $this->getHitPoints(),
        ];
    }
}
