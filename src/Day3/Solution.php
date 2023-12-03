<?php

declare(strict_types=1);

namespace App\Day3;

use App\BaseSolution;
use Support\Model\InputParser;

class Position {
    public function __construct(
        private readonly int $row,
        private readonly int $col
    ) {}

    public function col(): int { return $this->col; }
    public function row(): int { return $this->row; }
}

class Solution extends BaseSolution
{
    protected function parseInputFile(string $filePath): array
    {
        return InputParser::parseAsTwoDimensionalArray($filePath);
    }

    public function solvePart1(array $data)
    {
        $totalValues = 0;
        for ($row = 0; $row < sizeof($data); $row++) {
            for ($col = 0; $col < sizeof($data[$row]); $col++) {
                $intermittentValue = '';
                $currentCol = $col;
                $checkedValues = [];
                while (array_key_exists($currentCol, $data[$row]) && is_numeric($data[$row][$currentCol])) {
                    $checkedValues[] = $this->isPositionPossible($data, $row, $currentCol);
                    $intermittentValue .= $data[$row][$currentCol];
                    $currentCol++;
                    $col++; // Prevent the position checked multiple times, e.g. for 123 we check 123, not 123, then 23, then 3 by accident
                }
                if (in_array(true, $checkedValues)) {
                    $totalValues += (int) $intermittentValue;
                }
            }
        }
        return $totalValues;
    }

    public function isPositionPossible($data, $row, $col): bool
    {
        $neighbors = [
            [-1, -1], [-1, 0], [-1, 1],
            [0, -1],           [0, 1],
            [1, -1], [1, 0], [1, 1]
        ];

        foreach ($neighbors as [$nr, $nc]) {
            $neighborRow = $row + $nr;
            $neighborCol = $col + $nc;

            if (
                isset($data[$neighborRow][$neighborCol]) &&
                !(is_numeric($data[$neighborRow][$neighborCol]) || $data[$neighborRow][$neighborCol] === '.')
            ) {
                return true;
            }
        }

        return false;
    }

    public function solvePart2(array $data)
    {
        $total = 0;
        $gearPositions = $this->findAllGearPositions($data);
        foreach ($gearPositions as $gearPosition) {
            if ($this->getNeighbouringNumberCount($gearPosition, $data) == 2) {
                $total += $this->getNumbersForGear($gearPosition, $data);
            }
        }
        return $total;
    }

    public function findAllGearPositions($data): array
    {
        $gearPositions = [];
        for ($row = 0; $row < sizeof($data); $row++) {
            for ($col = 0; $col < sizeof($data[$row]); $col++) {
                if ($data[$row][$col] === '*') {
                    $gearPositions[] = new Position($row, $col);
                }
            }
        }

        return $gearPositions;
    }

    public function getNeighbouringNumberCount(Position $position, array $fullData): int
    {
        $top = [];
        $middle = [];
        $bottom = [];

        $top[] = $this->isNeighbourANumber($fullData, $position->row() - 1, $position->col() - 1);
        $top[] = $this->isNeighbourANumber($fullData, $position->row() - 1, $position->col());
        $top[] = $this->isNeighbourANumber($fullData, $position->row() - 1, $position->col() + 1);

        $middle[] = $this->isNeighbourANumber($fullData, $position->row(), $position->col() - 1);
        $middle[] = $this->isNeighbourANumber($fullData, $position->row(), $position->col() + 1);

        $bottom[] = $this->isNeighbourANumber($fullData, $position->row() + 1, $position->col() - 1);
        $bottom[] = $this->isNeighbourANumber($fullData, $position->row() + 1, $position->col());
        $bottom[] = $this->isNeighbourANumber($fullData, $position->row() + 1, $position->col() + 1);

        $count = 0;

        if ($top === [true, false, true]) {
            // This is the only configuration where any true can be considered 2 numbers available
            // e.g. given a
            // 3 2 1 . 1 2
            // . . . * . .
            // If this is not the case and any true is found, either all positions are a number and wrap the gear
            // or either edge (with or without the middle) is a number.
            $count += 2;
        } elseif (in_array(true, $top)) {
            $count++;
        }

        if ($bottom === [true, false, true]) {
            $count += 2;
        } elseif (in_array(true, $bottom)) {
            $count += 1;
        }

        if ($middle[0] === true) { $count++; }
        if ($middle[1] === true) { $count++; }

        return $count;
    }

    public function isNeighbourANumber($data, $row, $col): bool
    {
        if (!array_key_exists($row, $data)) {
            return false;
        }

        if (!array_key_exists($col, $data[$row])) {
            return false;
        }

        return is_numeric($data[$row][$col]);
    }

    /**
     * This is kinda dumb since we check every neighbor twice now... definitely not optimal
     */
    public function getNumbersForGear(Position $position, array $fullData)
    {
        $gearRow = $position->row();
        $gearCol = $position->col();
        $numbers = [];
        $checkedColumnPositions = [];

        $positionsToCheck = [
            [[$gearRow - 1, $gearCol - 1], [$gearRow - 1, $gearCol], [$gearRow - 1, $gearCol + 1]], // top
            [[$gearRow, $gearCol - 1], [$gearRow, $gearCol + 1]], // middle
            [[$gearRow + 1, $gearCol - 1], [$gearRow + 1, $gearCol], [$gearRow + 1, $gearCol + 1]], // bottom
        ];

        foreach ($positionsToCheck as $rowToCheck) {
            $intermittentValue = '';
            foreach ($rowToCheck as $position) {
                $curCol = $position[1];
                $curRow = $position[0];
                $leftPointer = $curCol;
                $rightPointer = $curCol;
                if (in_array($leftPointer, $checkedColumnPositions) || in_array($rightPointer, $checkedColumnPositions)) {
                    continue;
                }

                // Handle values to the right
                while (array_key_exists($rightPointer, $fullData[$curRow]) && is_numeric($fullData[$curRow][$rightPointer])) {
                    $intermittentValue .= $fullData[$curRow][$rightPointer];
                    $checkedColumnPositions[] = $rightPointer;
                    $rightPointer++;
                }

                // Handle values to the left
                while (array_key_exists($leftPointer, $fullData[$curRow]) && is_numeric($fullData[$curRow][$leftPointer])) {
                    // Check if right pointer already evaluated this value
                    if (in_array($leftPointer, $checkedColumnPositions)) {
                        $leftPointer--;
                        continue;
                    }

                    $intermittentValue = $fullData[$curRow][$leftPointer] . $intermittentValue; // Prepend
                    $checkedColumnPositions[] = $leftPointer;
                    $leftPointer--;
                }
                $checkedColumnPositions[] = $curCol;
                $numbers[] = !empty($intermittentValue) ? (int) $intermittentValue : 1;
                $intermittentValue = '';
            }
            $checkedColumnPositions = [];
        }

        return array_product($numbers);
    }
}