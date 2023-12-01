<?php

declare(strict_types=1);

namespace App\Test;

use PHPUnit\Framework\TestCase;
use Support\Model\InputParser;

class InputParserTest extends TestCase
{
    public function testFileWithOneValuePerLineCanBeLoadedAsArray()
    {
        $expectedValue = ['1', '2', '3', '4', '5', 'a', 'b', 'c'];
        $filePath = __DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'single-values-on-every-line.txt';
        $actualValue = InputParser::parseFileAsArraySplitOnLines($filePath);
        $this->assertSame($expectedValue, $actualValue);
    }

    public function testExceptionIsThrownForInvalidFilePath()
    {
        $filePath = 'some-non-existent-file.txt';
        $this->expectException('InvalidArgumentException');
        InputParser::parseFileAsArraySplitOnLines($filePath);
    }
}
