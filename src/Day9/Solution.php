<?php

declare(strict_types=1);

namespace App\Day9;

use App\BaseSolution;
use Support\Model\InputParser;

class Solution extends BaseSolution
{
    protected function parseInputFile(string $filePath): array
    {
        return array_map(function ($line) {
            $intermittent = explode(' ', $line);
            return array_map('intval', $intermittent);
        }, InputParser::parseFileAsArraySplitOnLines($filePath));
    }

    public function solvePart1(array $data)
    {
        return $this->getResult($data);
    }

    public function solvePart2(array $data)
    {
        foreach ($data as $key => $sequence) {
            $data[$key] = array_reverse($sequence);
        }

       return $this->getResult($data);
    }

    public function getResult(array $data)
    {
        $sequences = [];

        // Build top-down I guess
        foreach ($data as $k => $sequence) {
            $sequences[$k][] = $sequence;
            while (max($sequence) !== 0 || min($sequence) !== 0) {
                $newSequence = [];
                for ($i = 0; $i < sizeof($sequence); $i++) {
                    if (isset($sequence[$i + 1])) {
                        $newSequence[] = $sequence[$i + 1] - $sequence[$i];
                    }
                }
                $sequences[$k][] = $newSequence;
                $sequence = end($sequences[$k]);
            }
        }

        // Process results
        $total = 0;
        foreach ($sequences as &$sequence) {
            for ($i = sizeof($sequence) - 1; $i > 0; $i--) {
                $cur = end($sequence[$i]);
                if (isset($sequence[$i - 1])) {
                    $sequence[$i - 1][] = end($sequence[$i -1]) + $cur;
                }
            }
            $total += end($sequence[0]);
        }

        return $total;
    }
}