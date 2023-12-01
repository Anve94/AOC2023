<?php

declare(strict_types=1);

namespace App\Test;

use App\Day1\Solution;
use PHPUnit\Framework\TestCase;

class Day01Test extends TestCase
{
    public function testExampleInputSolvesProblem()
    {
        $filePath = __DIR__ . '/files/01-example.txt';
        $solution = (new Solution())->solve(1, $filePath);
        $this->assertEquals(142, $solution);
    }

    public function testEndOfLineValuesUseCorrectPointers()
    {
        $data = ['lmhtwoneghgtl2'];
        $solution = (new Solution())->solvePart1($data);
        $this->assertEquals(22, $solution);
    }

    public function testStartOfLineValuesUseCorrectPointers()
    {
        $data = ['2lmhtwoneghgtl'];
        $solution = (new Solution())->solvePart1($data);
        $this->assertEquals(22, $solution);
    }

    public function testPointerIsIgnoredWhenMultipleValuesArePresent()
    {
        $data = ['aur9iu2kdfdsl0lss9'];
        $solution = (new Solution())->solvePart1($data);
        $this->assertEquals(99, $solution);
    }

    public function testAdditionalLine()
    {
        $data = ['sixsrvldfour4seven'];
        $solution = (new Solution())->solvePart1($data);
        $this->assertEquals(44, $solution);
    }
}