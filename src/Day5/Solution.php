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
        $seeds = $data[0];
        $maps = $data[1];
        $ranges = [];

        for ($i = 0; $i < sizeof($seeds); $i += 2) {
            [$startRange, $endRange] = [$seeds[$i], $seeds[$i] + $seeds[$i + 1] - 1];
            $ranges[] = [$startRange, $endRange];
        }

        $highestTheoreticalSeed = 0;
        foreach ($ranges as $range) {
            if ($range[1] > $highestTheoreticalSeed) { $highestTheoreticalSeed = $range[1]; }
        }

        $highestTheoreticalSeed = max(array_column($ranges, 1));

        $chunkSize = ceil($highestTheoreticalSeed / 16);
        $chunkRanges = [];
        $currentValue = 1;
        while ($currentValue < $highestTheoreticalSeed) {
            $chunkRanges[] = [$currentValue, $currentValue + $chunkSize];
            $currentValue += $chunkSize;
        }

        $promises = [];

        foreach ($chunkRanges as $chunkRange) {
            $promises[] = React\Async\async(function ($chunkRange, $maps, $ranges) {
                $lastNumber = null;

                for ($destinationNumber = $chunkRange[0]; $destinationNumber < $chunkRange[1]; $destinationNumber++) {
                    if ($lastNumber !== null) {
                        break; // Value found in another chunk, no need to continue
                    }

                    foreach (array_reverse($maps) as $map) {
                        foreach ($map as $mapInfo) {
                            [$destination, $source, $range] = $mapInfo;
                            if ($lastNumber >= $destination && $lastNumber < $destination + $range) {
                                $offset = $lastNumber - $destination;
                                $lastNumber = $source + $offset;
                                break; // Don't evaluate next maps;
                            }
                        }
                    }

                    foreach ($ranges as $range) {
                        [$start, $end] = [$range[0], $range[1]];
                        if ($lastNumber > $start && $lastNumber < $end) {
                            echo($destinationNumber);
                        }
                    }
                }
            })();
        }

        \React\Promise\all($promises)->then(
            function () {

            },
            function ($results) {
                // The first resolved promise contains the result
                echo "Found the correct value: " . $results[0] . PHP_EOL;
                $found = $results[0];
            },
            function ($error) {
                echo "Error: " . $error->getMessage() . PHP_EOL;
            }
        );
    }
}