<?php

declare(strict_types=1);

namespace CardBattleGame\Domain;

final class Card
{
    const TYPE_DAMAGE = 'damage';
    const TYPE_ARMOR = 'armor';

    private static $allowedTypes = [
        self::TYPE_ARMOR,
        self::TYPE_DAMAGE,
    ];

    private $type;
    private $value;
    private $mpCost;

    public function __construct(string $type, int $value, int $mpCost)
    {
        if (!in_array($type, self::$allowedTypes)) {
            throw new \InvalidArgumentException('unknown type');
        }

        $this->type = $type;
        $this->value = $value;
        $this->mpCost = $mpCost;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getMpCost(): int
    {
        return $this->mpCost;
    }

    public function equals(Card $comparedCard): bool
    {
        return $comparedCard->getType() === $this->getType()
            && $comparedCard->getMpCost() === $this->getMpCost()
            && $comparedCard->getValue() === $this->getValue();
    }

    public function asArray(): array
    {
        return [
            'type' => $this->getType(),
            'value' => $this->getValue(),
            'move-points' => $this->getMpCost()
        ];
    }
}