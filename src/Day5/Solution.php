<?php

declare(strict_types=1);

namespace App\Day5;

use App\BaseSolution;
use Support\Model\InputParser;

class Solution extends BaseSolution
{
    public function parseInputFile(string $filePath): array
    {
        $rawData = InputParser::parseFileAsArraySplitOnLines($filePath);
        $cleanData = [];

        // Parse seeds
        $rawSeeds = array_shift($rawData);
        $seeds = explode(':', $rawSeeds);
        $seeds = trim($seeds[1]);
        $seedArray = explode(' ', $seeds);
        $seedArray = array_map('trim', $seedArray);
        $seedArray = array_map('intval', $seedArray);
        $cleanData[] = $seedArray;

        // Parse maps
        $maps = [];
        $map = [];
        foreach ($rawData as $line) {
            if (empty($line)) {
                continue;
            }

            if (str_contains($line, 'map')) {
                if (!empty($map)) {
                    $maps[] = $map;
                    $map = [];
                }
                continue;
            }

            $mapValues = explode(' ', $line);
            $mapValues = array_map('intval', $mapValues);
            $map[] = $mapValues;
        }
        $maps[] = $map;

        $cleanData[] = $maps;
        return $cleanData;

    }

    public function solvePart1(array $data)
    {
        $seeds = $data[0];
        $maps = $data[1];
        $finalDestinations = [];

        foreach ($seeds as $seedNumber) {
            $lastNumber = $seedNumber;
            foreach ($maps as $map) {
                foreach ($map as $mapInfo) {
                    [$destination, $source, $range] = [$mapInfo[0], $mapInfo[1], $mapInfo[2]];
                    if ($lastNumber >= $source && $lastNumber < $source + $range) {
                        $offset = $destination - $source;
                        $lastNumber += $offset;
                        break; // Don't evaluate next maps;
                    }
                }
            }
            $finalDestinations[] = $lastNumber;
        }

        return min($finalDestinations);
    }

    public function solvePart2(array $data)
    {
        // TODO: Implement solvePart2() method.
    }

}