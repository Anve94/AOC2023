<?php

declare(strict_types=1);

namespace App\Day7\CamelPoker;

use LogicException;

class Simulator
{
    public const HAND_VALUES = [
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        'T' => 10,
        'J' => 11,
        'Q' => 12,
        'K' => 13,
        'A' => 14,
    ];

    /**
     * @var array{highCard: Hand[],
     *       pair: Hand[],
     *       twoPair: Hand[],
     *       threeOfAKind: Hand[],
     *       fullHouse: Hand[],
     *       fourOfAKind: Hand[],
     *       fiveOfAKind: Hand[],
     *  }
     */
    public array $handTypes = [
        'highCard' => [],
        'pair' => [],
        'twoPair' => [],
        'threeOfAKind' => [],
        'fullHouse' => [],
        'fourOfAKind' => [],
        'fiveOfAKind' => []
    ];

    /**
     * @param array<array{"cards": string, "bid": int}> $hands
     */
    public function __construct(public array $hands) {}

    public function generateHandTypes(): self
    {
        foreach ($this->hands as $hand) {
            $handType = $this->getTypeForHand($hand["cards"]);
            $this->handTypes[$handType][] = new Hand($hand["cards"], $hand["bid"]);
        }

        return $this;
    }

    public function rankHandTypes(): self
    {
        foreach ($this->handTypes as &$hands) {
            usort($hands, function (Hand $a, Hand $b) {
                $aCards = str_split($a->getHand());
                $bCards = str_split($b->getHand());

                $aValues = array_map(function ($card) {
                    return self::HAND_VALUES[$card] ?? 0;
                }, $aCards);
                $bValues = array_map(function ($card) {
                    return self::HAND_VALUES[$card] ?? 0;
                }, $bCards);

                foreach ($aValues as $i => $valueA) {
                    $compare = $valueA <=> $bValues[$i];
                    if ($compare !== 0) {
                        return $compare;
                    }
                }
                return 0;
            });
        }
        return $this;
    }

    public function calculateResult(): int
    {
        $total = 0;
        $currentRankNumber = 1;
        foreach ($this->handTypes as $handType) {
            foreach ($handType as $hand) {
                $total += $hand->getBid() * $currentRankNumber;
                $currentRankNumber++;
            }
        }

        return $total;
    }

    public function getTypeForHand(string $hand): string
    {
        $cards = str_split($hand);
        $countValues = array_count_values($cards);
        $countValueSize = sizeof($countValues);

        // All values are the same -> 5 of a kind, e.g. AAAAA
        if ($countValueSize === 1) {
            return 'fiveOfAKind';
        }

        // All values are different -> high card, e.g. 23456
        if ($countValueSize === 5) {
            return 'highCard';
        }

        // Only possible option is a pair, e.g. AA234
        if ($countValueSize === 4) {
            return 'pair';
        }

        // Only possible options are a full house or 4 of a kind, e.g. AAJJJ or AJJJJ
        if ($countValueSize === 2) {
            // One count of 3 and one of 2 for full house
            if (max($countValues) === 3 && min($countValues) === 2) {
                return 'fullHouse';
            }
            return 'fourOfAKind';
        }

        // Can be both 2 pair and 3 of a kind, e.g. 22334 or 22234
        if ($countValueSize === 3) {
            if (in_array(3, $countValues)) {
                return 'threeOfAKind';
            }

            return 'twoPair';
        }

        throw new LogicException("Could not determine hand type");
    }
}