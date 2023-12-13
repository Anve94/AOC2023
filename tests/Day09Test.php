<?php

declare(strict_types=1);

namespace App\Test;

use App\Day9\Solution;
use PHPUnit\Framework\TestCase;

class Day09Test extends TestCase
{
    public function testPart1WithSampleInput()
    {
        $filePath = __DIR__ . '/files/09-sample.txt';
        $solution = new Solution();
        $this->assertEquals(114, $solution->solve(1, $filePath));
    }

    public function testPart2WithSampleInput()
    {
        $filePath = __DIR__ . '/files/09-sample.txt';
        $solution = new Solution();
        $this->assertEquals(2, $solution->solve(2, $filePath));
    }
}