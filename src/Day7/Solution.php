<?php

declare(strict_types=1);

namespace App\Day7;

use App\BaseSolution;
use App\Day7\CamelPoker\Simulator;
use Support\Model\InputParser;

class Solution extends BaseSolution
{
    /**
     * @return array<array{"cards": string, "bid": int}>
     */
    public function parseInputFile(string $filePath): array
    {
        $lines = InputParser::parseFileAsArraySplitOnLines($filePath);
        $data = [];

        foreach ($lines as $line) {
            $lineData = explode(" ", $line);
            $data[] = [
                "cards" => $lineData[0],
                "bid" => (int) $lineData[1],
            ];
        }

        return $data;
    }

    public function solvePart1(array $data): int
    {
        return (new Simulator($data))
            ->generateHandTypes()
            ->rankHandTypes()
            ->calculateResult();
    }

    public function solvePart2(array $data)
    {
        // TODO: Implement solvePart2() method.
    }

}