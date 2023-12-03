<?php

declare(strict_types=1);

namespace App\Test;

use App\Day3\Solution;
use PHPUnit\Framework\TestCase;

class Day03Test extends TestCase
{
    public function testWhetherPositionsCanBeCheckedForSymbols()
    {
        $data = [
            ['1', '.', '.', '1', '$'],
            ['2', '5', '$', '2', '3'],
        ];
        $solution = new Solution();
        $this->assertTrue($solution->isSymbolAtNeighbour($data, 0, 0));
        $this->assertTrue($solution->isSymbolAtNeighbour($data, 0, 3));
        $this->assertFalse($solution->isSymbolAtNeighbour($data, 0, 4));
        $this->assertTrue($solution->isSymbolAtNeighbour($data, 0, 99)); // Out of bounds
        $this->assertTrue($solution->isSymbolAtNeighbour($data, -12, 0)); // Out of bounds
        $this->assertTrue($solution->isSymbolAtNeighbour($data, 1, 0));
        $this->assertTrue($solution->isSymbolAtNeighbour($data, 1, 1));
        $this->assertFalse($solution->isSymbolAtNeighbour($data, 1, 2));
    }

    public function testSingleRowWithNoSymbolsCanBeParsedCorrectly()
    {
        $data = [
            ['1', '2', '3', '.', '.', '1', '2', '3'],
        ];
        $this->assertEquals(0, (new Solution())->solvePart1($data));
    }

    public function testSingleRowWithSymbolCanBeParsedCorrectly()
    {
        $data = [
            ['1', '2', '3', '$', '@', '1', '2', '3'],
        ];
        $this->assertEquals(246, (new Solution())->solvePart1($data));
    }

    public function testMultipleRowsWithSomeSymbols()
    {
        $data = [
            ['1', '2', '3', '.', '.', '1', '2', '3'],
            ['1', '2', '$', '.', '.', '1', '2', '3'],
            ['1', '$', '3', '.', '.', '?', '2', '3'],
        ];
        $this->assertEquals(123+12+123+1+3+23, (new Solution())->solvePart1($data));
    }

    public function testPart1WithSampleInput()
    {
        $filePath = __DIR__ . '/files/03-example.txt';
        $solution = (new Solution())->solve(1, $filePath);
        $this->assertEquals(4361, $solution);
    }
}