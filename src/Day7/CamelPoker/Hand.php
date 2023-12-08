<?php

declare(strict_types=1);

namespace App\Day7\CamelPoker;

class Hand
{
    public function __construct(
        private readonly string $cards,
        private readonly int $bid
    ) {}

    /**
     * @return string
     */
    public function getCards(): string
    {
        return $this->cards;
    }

    /**
     * @return int
     */
    public function getBid(): int
    {
        return $this->bid;
    }
}