<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

abstract class BaseSolution
{
    public function solve(int $part, string $filePath)
    {
        $startingData = $this->parseInputFile($filePath);

        if ($part === 1) {
            return $this->solvePart1($startingData);
        }

        if ($part === 2) {
            return $this->solvePart2($startingData);
        }

        throw new InvalidArgumentException('Please provide either 1 or 2 to signify which part to solve');
    }

    abstract protected function parseInputFile(string $filePath): array;

    // Public to allow access from unit test with pre-formatted data
    abstract public function solvePart1(array $data);

    abstract public function solvePart2(array $data);
}