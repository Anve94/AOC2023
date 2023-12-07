<?php

declare(strict_types=1);

namespace App\Day7\CamelPoker;

readonly class Hand
{
    public function __construct(
        private string $hand,
        private int    $bid
    ) {}

    /**
     * @return string
     */
    public function getHand(): string
    {
        return $this->hand;
    }

    /**
     * @return int
     */
    public function getBid(): int
    {
        return $this->bid;
    }
}