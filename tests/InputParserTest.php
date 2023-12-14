<?php

declare(strict_types=1);

namespace App\Test;

use Algorithm\Coordinate\Point;
use PHPUnit\Framework\TestCase;
use Support\Model\InputParser;

class InputParserTest extends TestCase
{
    public function testFileWithOneValuePerLineCanBeLoadedAsArray()
    {
        $expectedValue = ['1', '2', '3', '4', '5', 'a', 'b', 'c'];
        $filePath = __DIR__ . '/files/single-values-on-every-line.txt';
        $actualValue = InputParser::parseFileAsArraySplitOnLines($filePath);
        $this->assertSame($expectedValue, $actualValue);
    }

    public function testExceptionIsThrownForInvalidFilePath()
    {
        $filePath = 'some-non-existent-file.txt';
        $this->expectException('InvalidArgumentException');
        InputParser::parseFileAsArraySplitOnLines($filePath);
    }

    public function testCanConvertLineTo2dArray()
    {
        $filePath = __DIR__ . '/files/2d-array-test.txt';
        $expectedValue = [
            ['a', 'b', 'c', 'd'],
            ['1', '2', '3', '4'],
        ];
        $actualValue = InputParser::parseAsTwoDimensionalArray($filePath);
        $this->assertEquals($expectedValue, $actualValue);
    }

    public function testCanConvertLinesToCoordinatePoints()
    {
        $filePath = __DIR__ . '/files/2d-array-test.txt';
        $expectedValue = [
            [new Point(0, 0, 'a'), new Point(0, 1, 'b'), new Point(0, 2, 'c'), new Point(0, 3 , 'd')],
            [new Point(1, 0, '1'), new Point(1, 1, '2'), new Point(1, 2, '3'), new Point(1, 3 , '4')],
        ];
        $actualValue = InputParser::parseAsTwoDimensionalCoordinatesArray($filePath);
        $this->assertEquals($expectedValue, $actualValue);
    }
}
