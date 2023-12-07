<?php

declare(strict_types=1);

namespace App\Day7\CamelPoker;

readonly class Hand
{
    public function __construct(
        private string $cards,
        private int    $bid
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