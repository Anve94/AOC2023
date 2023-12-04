<?php

declare(strict_types=1);

namespace App\Test;

use App\Day4\Solution;
use PHPUnit\Framework\TestCase;

class Day04Test extends TestCase
{
    public function testSampleInputCanBeParsedCorrectly()
    {
        $filePath = __DIR__ . '/files/04-sample.txt';
        $data = (new Solution())->parseInputFile($filePath);
        $dataToTest = $data[0];
        $expected = [
            ['41', '48', '83', '86', '17'],
            ['83', '86', '6', '31', '17', '9', '48', '53']
        ];
        $this->assertEquals($expected, $dataToTest);
    }

    public function testPart1ForSampleInput()
    {
        $filePath = __DIR__ . '/files/04-sample.txt';
        $solution = (new Solution())->solve(1, $filePath);
        $this->assertEquals(13, $solution);
    }

    public function testPart2ForSampleInput()
    {
        $filePath = __DIR__ . '/files/04-sample.txt';
        $solution = (new Solution())->solve(2, $filePath);
        $this->assertEquals(30, $solution);
    }
}