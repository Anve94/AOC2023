<?php

declare(strict_types=1);

namespace App\Day2;

use Support\Model\InputParser;

class Solution extends \App\BaseSolution
{
    protected function parseInputFile(string $filePath): array
    {
        return InputParser::parseFileAsArraySplitOnLines($filePath);
    }

    public function solvePart1(array $data)
    {
        return (new GameParser($data))
            ->createGameResultScoring()
            ->getSumOfPossibleGames();
    }

    public function solvePart2(array $data)
    {
        // TODO: Implement solvePart2() method.
    }
}