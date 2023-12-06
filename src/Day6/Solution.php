<?php

declare(strict_types=1);

namespace App\Day6;

use App\BaseSolution;
use Support\Model\InputParser;

class Solution extends BaseSolution
{
    public function parseInputFile(string $filePath): array
    {
        $input = InputParser::parseFileAsArraySplitOnLines($filePath);
        return array_map(null, $this->getDigits($input[0]), $this->getDigits($input[1]));
    }

    private function getDigits(string $input): array
    {
        preg_match_all('!\d+!', $input, $matches);
        return $matches[0];
    }

    private function calculateBoundaries(int $time, int $distance): array
    {
        $leftPointer = 1;
        $rightPointer = $time - 1;
        $leftBound = null;
        $rightBound = null;

        while (($leftPointer <= $rightPointer) && (!isset($leftBound) || !isset($rightBound))) {
            if (!isset($leftBound) && ($time - $leftPointer) * $leftPointer > $distance) {
                $leftBound = $leftPointer;
            }

            if (!isset($rightBound) && ($time - $rightPointer) * $rightPointer > $distance) {
                $rightBound = $rightPointer;
            }

            $leftPointer++;
            $rightPointer--;
        }

        return [$leftBound, $rightBound];
    }

    public function solvePart1(array $data)
    {
        $total = 1;
        foreach ($data as $race) {
            [$leftBound, $rightBound] = $this->calculateBoundaries((int) $race[0], (int) $race[1]);
            $total *= $rightBound - $leftBound + 1;
        }

        return $total;
    }

    public function solvePart2(array $data)
    {
        $times = '';
        $distances = '';
        foreach ($data as $race) {
            $times .= $race[0];
            $distances .= $race[1];
        }

        [$leftBound, $rightBound] = $this->calculateBoundaries((int) $times, (int) $distances);
        return $rightBound - $leftBound + 1;
    }
}