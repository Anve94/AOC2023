<?php

declare(strict_types=1);

namespace App\Test;

use Algorithm\Coordinate\Point;
use App\Day10\Solution;
use PHPUnit\Framework\TestCase;

class Day10Test extends TestCase
{
    public function testThrowsExceptionOnInputWithoutAStartingPoint()
    {
        $filePath = __DIR__ . '/files/10-sample-no-starting-point.txt';
        $this->expectException('LogicException');
        $solution = new Solution();
        $solution->getStartingLocation($solution->parseInputFile($filePath));
    }

    public function testCanFindStartingPointInSimpleSampleData()
    {
        $filePath = __DIR__ . '/files/10-sample.txt';
        $solution = new Solution();
        $this->assertEquals(
            new Point(1, 1, 'S'),
            $solution->getStartingLocation($solution->parseInputFile($filePath))
        );
    }
}