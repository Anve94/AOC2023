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
        preg_match_all('!\d+!', $input[0], $matches);
        $times = $matches[0];
        preg_match_all('!\d+!', $input[1], $matches);
        $distances = $matches[0];

        return array_map(null, $times, $distances);
    }

    public function solvePart1(array $data)
    {
        $ranges = [];
        foreach ($data as $race) {
            $time = (int) $race[0];
            $distance = (int) $race[1];
            $leftPointer = 1;
            $rightPointer = $time - 1;
            $leftBoundFound = false;
            $rightBoundFound = false;
            $leftBound = null;
            $rightBound = null;
            while ($leftPointer <= $rightPointer) { // Check same middle position with both pointers in case only 1 timing is possible.
                if (!$leftBoundFound && ($time - $leftPointer) * $leftPointer > $distance ) {
                    $leftBoundFound = true;
                    $leftBound = $leftPointer;
                }

                if (!$rightBoundFound && ($time - $rightPointer) * $rightPointer > $distance) {
                    $rightBoundFound = true;
                    $rightBound = $rightPointer;
                }
                $leftPointer++;
                $rightPointer--;
            }
            $ranges[] = [$leftBound, $rightBound];
        }

        $total = 1;
        foreach ($ranges as $range) {
            $diff = $range[1] - $range[0] + 1; // +1 because inclusive end
            $total *= $diff;
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

        $time = (int) $times;
        $distance = (int) $distances;
        $leftPointer = 1;
        $rightPointer = $time - 1;
        $leftBoundFound = false;
        $rightBoundFound = false;
        $leftBound = null;
        $rightBound = null;
        while ($leftPointer <= $rightPointer) { // Check same middle position with both pointers in case only 1 timing is possible.
            if ($leftBoundFound && $rightBoundFound) {
                break;
            }

            if (!$leftBoundFound && ($time - $leftPointer) * $leftPointer > $distance ) {
                $leftBoundFound = true;
                $leftBound = $leftPointer;
            }

            if (!$rightBoundFound && ($time - $rightPointer) * $rightPointer > $distance) {
                $rightBoundFound = true;
                $rightBound = $rightPointer;
            }
            $leftPointer++;
            $rightPointer--;
        }

        return $rightBound - $leftBound + 1;
    }
}