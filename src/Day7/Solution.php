<?php

declare(strict_types=1);

namespace App\Day7;

use App\BaseSolution;
use Support\Model\InputParser;

class Solution extends BaseSolution
{
    public array $hits = [
        'highCard' => [],
        'pair' => [],
        'twoPair' => [],
        'threeOfAKind' => [],
        'fullHouse' => [],
        'fourOfAKind' => [],
        'fiveOfAKind' => []
    ];

    public function parseInputFile(string $filePath): array
    {
        $lines = InputParser::parseFileAsArraySplitOnLines($filePath);
        $data = [];
        foreach ($lines as $line) {
            $lineData = explode(" ", $line);
            $data[] = [$lineData[0], (int) $lineData[1]];
        }

        return $data;
    }

    public function solvePart1(array $data)
    {

    }

    public function solvePart2(array $data)
    {
        // TODO: Implement solvePart2() method.
    }

}