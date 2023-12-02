<?php

declare(strict_types=1);

namespace App\Day2;

class GameParser
{
    public array $games = [];
    public array $possibleGameNumbers = [];
    public const GAME_LIMITS = [
        'red' => 12,
        'green' => 13,
        'blue' => 14
    ];

    public function __construct(array $gameStates)
    {
        foreach ($gameStates as $index => $gameState) {
            $gameNumber = $index + 1;
            $chunks = explode(':', $gameState);
            $roundsList = [];
            $rawRound = trim($chunks[1]);
            $rounds = explode(';', $rawRound);
            foreach ($rounds as $round) {
                $round = trim($round);
                $cubesFound = explode(',', $round);
                $roundList = [];
                foreach ($cubesFound as $cubeFound) {
                    $cubeFound = trim($cubeFound);
                    $valueColorPair = explode(' ', $cubeFound);
                    (int) $amount = $valueColorPair[0];
                    $color = $valueColorPair[1];
                    $roundList[$color] = $amount;
                }
                $roundsList[] = $roundList;

            }
            $this->games[$gameNumber] = $roundsList;
        }
    }

    public function createGameResultScoring(): self
    {
        foreach ($this->games as $gameNumber => $rounds) {
            $gameIsPossible = true;

            foreach ($rounds as $round) {
                foreach ($round as $color => $amount) {
                    if ($amount > self::GAME_LIMITS[$color]) {
                        $gameIsPossible = false;
                        break;
                    }
                }
            }

            if ($gameIsPossible) {
                $this->possibleGameNumbers[] = $gameNumber;
            }
        }

        return $this;
    }

    public function getSumOfPossibleGames(): int
    {
        return array_sum($this->possibleGameNumbers);
    }
}