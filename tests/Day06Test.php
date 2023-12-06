<?php

declare(strict_types=1);

namespace App\Test;

use App\Day6\Solution;
use PHPUnit\Framework\TestCase;

class Day06Test extends TestCase
{
    public function testInputParsingCanBeHandledAsExpected()
    {
        $filePath = __DIR__ . '/files/06-sample.txt';
        $solution = new Solution();
        $expected = [
            [7, 9], [15, 40], [30, 200],
        ];
        $this->assertEquals($expected, $solution->parseInputFile($filePath));
    }

    public function testPartOneWithSampleInput()
    {
        $filePath = __DIR__ . '/files/06-sample.txt';
        $this->assertEquals(288, (new Solution())->solve(1, $filePath));
    }

    public function testPartTwoWithSampleInput()
    {
        $filePath = __DIR__ . '/files/06-sample.txt';
        $this->assertEquals(71503, (new Solution())->solve(2, $filePath));
    }
}