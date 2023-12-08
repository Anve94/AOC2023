<?php

declare(strict_types=1);

namespace App\Test;

use Algorithm\BinaryTree\Tree as BinaryTree;
use App\Day8\Solution;
use PHPUnit\Framework\TestCase;

/**
 * @property BinaryTree $expectedSampleMap
 */
class Day08Test extends TestCase
{
    public function setUp(): void
    {
        $this->expectedSampleMap = [
            'AAA' => ['BBB', 'CCC'],
            'BBB' => ['DDD', 'EEE'],
            'CCC' => ['ZZZ', 'GGG'],
            'DDD' => ['DDD', 'DDD'],
            'EEE' => ['EEE', 'EEE'],
            'GGG' => ['GGG', 'GGG'],
            'ZZZ' => ['ZZZ', 'ZZZ'],
        ];
    }

    /**
     * The sample input already is a parsable tree format, so every nodeValue encountered is guaranteed to already
     * have been defined when the input is being evaluated from top to bottom. The real input does not have this,
     * and we cannot make this assumption then, but having nodes always exist is a good first test case.
     *
     * @return void
     */
    public function testCanGenerateBinaryTreeFromSampleInput()
    {
        $filePath = __DIR__ . '/files/08-sample.txt';
        $actualMap = (new Solution())->parseInputFile($filePath)[1];
        $this->assertEquals($this->expectedSampleMap, $actualMap);
    }

    public function testPartOneWithSampleInput()
    {
        $filePath = __DIR__ . '/files/08-sample.txt';
        $this->assertEquals(2, (new Solution())->solve(1, $filePath));
    }

    public function testPartOneWithAlternativeSampleInput()
    {
        $filePath = __DIR__ . '/files/08-sample-alternative.txt';
        $this->assertEquals(6, (new Solution())->solve(1, $filePath));
    }
}