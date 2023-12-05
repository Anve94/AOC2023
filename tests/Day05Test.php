<?php

declare(strict_types=1);

namespace App\Test;

use App\Day5\Solution;
use PHPUnit\Framework\TestCase;

class Day05Test extends TestCase
{
    public function testInputCanBeParsedCorrectly()
    {
        $filePath = __DIR__ . '/files/05-input-parsing-test.txt';
        $expected = [
            [79, 14, 55, 13],
            [
                [
                    [50, 98, 2],
                    [52, 50, 48]
                ],
                [
                    [0, 15, 37],
                    [37, 52, 2],
                    [39, 0, 15]
                ]
            ]
        ];
        $this->assertEquals(
            $expected,
            (new Solution())->parseInputFile($filePath)
        );
    }

    public function testPart1WithSampleInput()
    {
        $filePath = __DIR__ . '/files/05-sample.txt';
        $this->assertEquals(
            35,
            (new Solution())->solve(1, $filePath)
        );
    }
}