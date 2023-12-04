<?php

declare(strict_types=1);

namespace App\Day4;

use App\BaseSolution;
use Support\Model\InputParser;

class Solution extends BaseSolution
{
    public function parseInputFile(string $filePath): array
    {
        $data = InputParser::parseFileAsArraySplitOnLines($filePath);
        $cleanedData = [];
        foreach ($data as $row) {
            $numbers = explode(': ', $row)[1];
            $splitNumbers = explode('|', $numbers);
            $leftNumbers = trim($splitNumbers[0]);
            $rightNumbers = trim($splitNumbers[1]);
            $winningNumbers = explode(' ', $leftNumbers);
            $myNumbers = explode(' ', $rightNumbers);
            $winningNumbers = array_map('trim', $winningNumbers);
            $myNumbers = array_map('trim', $myNumbers);
            $winningNumbers = array_filter($winningNumbers);
            $myNumbers = array_filter($myNumbers);
            $cleanedData[] = [array_values($winningNumbers), array_values($myNumbers)]; // Reindex array too because PHPUnit checks key equality
        }

        return $cleanedData;
    }

    public function solvePart1(array $data)
    {
        $score = 0;
        foreach ($data as $scratchCard) {
            $winningNumbers = $scratchCard[0];
            $myNumbers = $scratchCard[1];

            $matches = array_intersect($winningNumbers, $myNumbers);
            $hitCounts = sizeOf($matches);
            // Sum of geometric series? See: https://en.wikipedia.org/wiki/Geometric_series
            if ($hitCounts > 0) {
                // If no hits, 2^-1 = 0.5 which is no bueno
                $score += pow(2, $hitCounts - 1);
            }

        }

        return $score;
    }

    public function solvePart2(array $data)
    {
        $copyCounts = [];
        foreach ($data as $index => $card) {
            $copyCounts[$index + 1] = 1;
        }

        foreach ($data as $index => $card) {
            $cardNumber = $index + 1;
            $matchCount = count(array_intersect($card[0], $card[1]));

            for ($i = 1; $i <= $matchCount; $i++) {
                if (isset($copyCounts[$i + $cardNumber])) {
                    $copyCounts[$i + $cardNumber] += $copyCounts[$cardNumber];
                }
            }
        }

        return array_sum(array_values($copyCounts));
    }
}