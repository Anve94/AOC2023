<?php

declare(strict_types=1);

namespace App\Day10;

use Algorithm\Coordinate\Point;
use App\BaseSolution;
use LogicException;
use Support\Model\InputParser;

class Solution extends BaseSolution
{
    public function parseInputFile(string $filePath): array
    {
        return InputParser::parseAsTwoDimensionalCoordinatesArray($filePath);
    }

    public function solvePart1(array $data)
    {
        $currentLocation = $this->getStartingLocation($data);
        $hasLeftStartingPoint = false; // Don't eval first S since it's the starting point
        $steps = 0;
        while ($hasLeftStartingPoint && $currentLocation->getVal() !== 'S') {
            $hasLeftStartingPoint = true;
            $currentLocation = $this->getNextLocation($currentLocation);
            $steps++;
        }

        return $steps / 2;
    }

    public function solvePart2(array $data)
    {
        // TODO: Implement solvePart2() method.
    }

    /**
     * @param array $data
     * @return Point
     * @throws LogicException if no starting point was found
     */
    public function getStartingLocation(array $data): Point
    {
        foreach ($data as $row) {
            foreach ($row as $point) {
                /** @var Point $point */
                if ($point->getVal() === 'S') {
                    return $point;
                }
            }
        }

        throw new LogicException('No starting point found in given dataset');
    }

    public function getNextLocation(Point $currentLocation): Point
    {
        // TODO: implement
    }
}