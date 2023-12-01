<?php

declare(strict_types=1);

namespace App\Day1;

use App\BaseSolution;
use Support\Model\InputParser;

class Solution extends BaseSolution
{
    private const TOKEN_VALUE_MAP = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        'one' => '1',
        'two' => '2',
        'three' => '3',
        'four' => '4',
        'five' => '5',
        'six' => '6',
        'seven' => '7',
        'eight' => '8',
        'nine' => '9'
    ];

    public function solvePart1(array $data)
    {
        $valuesFondOnLine = [];

        # 2-pointer implementation, left pointer going right until hit and right pointer going left until hit
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
        return array_sum(array_map([$this, 'parseLineForTokens'], $data));
    }

    protected function parseInputFile(string $filePath): array
    {
        return InputParser::parseFileAsArraySplitOnLines($filePath);
    }

    private function parseLineForTokens(string $line): int
    {
        $leftFound = null;
        $rightFound = null;
        $lowestIndex = PHP_INT_MAX;
        $highestIndex = PHP_INT_MIN;

        foreach (array_keys(self::TOKEN_VALUE_MAP) as $tokenToLookup) {
            $tokenToLookup = (string) $tokenToLookup;

            $firstHit = strpos($line, $tokenToLookup);
            $lastHit = strrpos($line, $tokenToLookup);

            if ($firstHit !== false && $firstHit < $lowestIndex) {
                $lowestIndex = $firstHit;
                $leftFound = self::TOKEN_VALUE_MAP[$tokenToLookup];
            }

            if ($lastHit !== false && $lastHit > $highestIndex ) {
                $highestIndex = $lastHit;
                $rightFound = self::TOKEN_VALUE_MAP[$tokenToLookup];
            }
        }

        $lineAnswer = $leftFound . $rightFound;
        return (int) $lineAnswer;
    }
}