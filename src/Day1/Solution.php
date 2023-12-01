<?php

declare(strict_types=1);

namespace App\Day1;

use App\BaseSolution;
use Support\Model\InputParser;

class Solution extends BaseSolution
{
    public function solvePart1(array $data)
    {
        $valuesFondOnLine = [];

        foreach ($data as $line) {
            $leftValue = null;
            $rightValue = null;
            $endPointer = strlen($line) - 1;

            for ($i = 0; $i < strlen($line); $i++) {
                if ($leftValue == null && is_numeric($line[$i])) { $leftValue = $line[$i]; }
                if ($rightValue == null && is_numeric($line[$endPointer])) { $rightValue = $line[$endPointer]; }

                if ($leftValue !== null && $rightValue !== null) {
                    break;
                }

                $endPointer--;
            }

            $valuesFondOnLine[] = (int) $leftValue . $rightValue;
        }


        return array_sum($valuesFondOnLine);
    }

    public function solvePart2(array $data)
    {
        return '';
    }

    protected function parseInputFile(string $filePath): array
    {
        return InputParser::parseFileAsArraySplitOnLines($filePath);
    }
}