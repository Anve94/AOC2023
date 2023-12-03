<?php

declare(strict_types=1);

namespace App\Test;

use App\Day3\Position;
use App\Day3\Solution;
use PHPUnit\Framework\TestCase;
use Support\Model\InputParser;

class Day03Test extends TestCase
{
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

    /** Start of part 2 test cases */

    public function testGearPositionsCanBeFoundCorrectlyInSampleInput()
    {
        $filePath = __DIR__ . '/files/03-example.txt';
        $data = InputParser::parseAsTwoDimensionalArray($filePath);
        /** @var Position[] $gearPositions */
        $gearPositions = (new Solution())->findAllGearPositions($data);
        // Gears are on (1, 3), (3, 4) and (8, 5)
        $this->assertEquals([1, 3], [$gearPositions[0]->row(), $gearPositions[0]->col()]);
        $this->assertEquals([4, 3], [$gearPositions[1]->row(), $gearPositions[1]->col()]);
        $this->assertEquals([8, 5], [$gearPositions[2]->row(), $gearPositions[2]->col()]);
    }

    public function testNumberCountForGearsInSampleFile()
    {
        $filePath = __DIR__ . '/files/03-example.txt';
        $data = InputParser::parseAsTwoDimensionalArray($filePath);
        $solution = new Solution();
        $gears = $solution->findAllGearPositions($data);
        $this->assertEquals(2, $solution->getNeighbouringNumberCount($gears[0], $data));
        $this->assertEquals(1, $solution->getNeighbouringNumberCount($gears[1], $data));
        $this->assertEquals(2, $solution->getNeighbouringNumberCount($gears[2], $data));
    }

    public function testPart2WithSampleInput()
    {
        $filePath = __DIR__ . '/files/03-example.txt';
        $solution = (new Solution())->solve(2, $filePath);
        $this->assertEquals(467835, $solution);
    }

    public function testEdgeCasesForPart2()
    {
        $data = [
            ['1', '2', '3', '.', '.', '1', '2', '3'],
            ['.', '*', '.', '.', '.', '1', '2', '3'],
            ['2', '$', '/', '.', '.', '?', '2', '3'],
        ];
        $this->assertEquals(123*2, (new Solution())->solvePart2($data));

        $data = [
            ['2', '.', '3', '.', '.', '1', '2', '3'],
            ['.', '*', '.', '.', '.', '1', '2', '3'],
            ['.', '$', '/', '.', '.', '?', '2', '3'],
        ];
        $this->assertEquals(6, (new Solution())->solvePart2($data));
    }
}