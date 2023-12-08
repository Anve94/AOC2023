<?php

declare(strict_types=1);

namespace App\Day8;

use App\BaseSolution;
use Support\Model\InputParser;

class Solution extends BaseSolution
{
    public function parseInputFile(string $filePath): array
    {
        $lines = InputParser::parseFileAsArraySplitOnLines($filePath);
        $nodeMap = [];
        $directionalSteps = array_shift($lines);
        array_shift($lines); // Discard empty line
        foreach ($lines as $line) {
            [$nodeValue, $leftValue, $rightValue] = $this->parseLine($line);
            $nodeMap[$nodeValue] = [$leftValue, $rightValue];
        }

        return [$directionalSteps, $nodeMap];
    }

    private function parseLine(string $line) {
        preg_match_all('/[A-Z]{3}/', $line, $matches);
        $nodeValue = $matches[0][0];
        $leftValue = $matches[0][1];
        $rightValue = $matches[0][2];

        return [$nodeValue, $leftValue, $rightValue];
    }

    public function solvePart1(array $data)
    {
        [$directionalSteps, $nodeMap] = $data;
        $directionalSteps = str_split($directionalSteps);
        $directionSize = sizeof($directionalSteps);
        $stepIndex = 0;
        $currentNode = 'AAA';
        while ($currentNode !== 'ZZZ') {
            $direction = $directionalSteps[$stepIndex % $directionSize];
            if ($direction === 'L') {
                $currentNode = $nodeMap[$currentNode][0];
            } else {
                $currentNode = $nodeMap[$currentNode][1];
            }

            $stepIndex++;
        }

        return $stepIndex;
    }

    public function solvePart2(array $data)
    {
        // TODO: Implement solvePart2() method.
    }
}