<?php

declare(strict_types=1);

namespace App\Day3;

use App\BaseSolution;
use Support\Model\InputParser;

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
        return (
            $this->isSymbolAtNeighbour($data, $row - 1, $col - 1) ||
            $this->isSymbolAtNeighbour($data, $row - 1, $col) ||
            $this->isSymbolAtNeighbour($data, $row - 1, $col + 1) ||
            $this->isSymbolAtNeighbour($data, $row, $col - 1) ||
            $this->isSymbolAtNeighbour($data, $row, $col + 1) ||
            $this->isSymbolAtNeighbour($data, $row + 1, $col - 1) ||
            $this->isSymbolAtNeighbour($data, $row + 1, $col) ||
            $this->isSymbolAtNeighbour($data, $row + 1, $col + 1)
        );
    }

    public function isSymbolAtNeighbour($data, $row, $col): bool
    {
        if (!array_key_exists($row, $data)) {
            // If position doesn't exist we are at the top/bottom schematic boundary
            return false; // Evaluate out of bounds as if no symbol is there
        }

        if (!array_key_exists($col, $data[$row])) {
            // If position doesn't exist we are at the left/right schematic boundary
            return false;
        }

        // Position is safe to access
        $value = $data[$row][$col];
        return !(is_numeric($value) || $value === '.');
    }

    public function solvePart2(array $data)
    {
        // TODO: Implement solvePart2() method.
    }

}