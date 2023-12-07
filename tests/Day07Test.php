<?php

declare(strict_types=1);

namespace App\Test;

use App\Day7\Solution;
use PHPUnit\Framework\TestCase;

class Day07Test extends TestCase
{
    public function testInputCanBeParsed()
    {
        $filePath = __DIR__ . '/files/07-parsing-sample.txt';
        $expected = [
            ['74775', 621],
            ['6A4A6', 178]
        ];
        $this->assertSame(
            $expected,
            (new Solution())->parseInputFile($filePath)
        );
    }
}