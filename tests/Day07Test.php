<?php

declare(strict_types=1);

namespace App\Test;

use App\Day7\CamelPoker\Hand;
use App\Day7\CamelPoker\Simulator;
use App\Day7\Solution;
use LogicException;
use PHPUnit\Framework\TestCase;

class Day07Test extends TestCase
{
    public function testInputCanBeParsed()
    {
        $filePath = __DIR__ . '/files/07-parsing-sample.txt';
        $expected = [
            ['cards' => '74775', 'bid' => 621],
            ['cards' => '6A4A6', 'bid' => 178]
        ];
        $this->assertSame(
            $expected,
            (new Solution())->parseInputFile($filePath)
        );
    }

    public function testSampleInputForPart1()
    {
        $filePath = __DIR__ . '/files/07-sample.txt';
        $expected = 6440;
        $this->assertSame($expected, (new Solution())->solve(1, $filePath));
    }

    public function testGetTypeForHandFiveOfAKind(): void
    {
        $simulator = new Simulator([]);
        $this->assertEquals("fiveOfAKind", $simulator->getTypeForHand("44444"));
    }

    public function testGetTypeForHandHighCard(): void
    {
        $simulator = new Simulator([]);
        $this->assertEquals("highCard", $simulator->getTypeForHand("AJQKT"));
    }

    public function testGetTypeForHandFourOfAKind(): void
    {
        $simulator = new Simulator([]);
        $this->assertEquals("fourOfAKind", $simulator->getTypeForHand("QQQQJ"));
    }

    public function testGetTypeForHandPair(): void
    {
        $simulator = new Simulator([]);
        $this->assertEquals("pair", $simulator->getTypeForHand("22345"));
    }

    public function testGetTypeForHandFullHouse(): void
    {
        $simulator = new Simulator([]);
        $this->assertEquals("fullHouse", $simulator->getTypeForHand("TTT22"));
    }

    public function testGetTypeForHandTwoPair(): void
    {
        $simulator = new Simulator([]);
        $this->assertEquals("twoPair", $simulator->getTypeForHand("JJ223"));
    }

    public function testGetTypeForHandThreeOfAKind(): void
    {
        $simulator = new Simulator([]);
        $this->assertEquals("threeOfAKind", $simulator->getTypeForHand("JA222"));
    }

    public function testGetTypeForHandException(): void
    {
        $simulator = new Simulator([]);
        $this->expectException(LogicException::class);;
        $simulator->getTypeForHand("123456");
    }

    public function testCardTypesArrayCanBeBuildSuccessfully()
    {
        $simulator = new Simulator([]);
        $expected = [
            "fiveOfAKind" => [],
            "highCard" => [],
            "fourOfAKind" => [],
            "pair" => [],
            "fullHouse" => [],
            "twoPair" => [],
            'threeOfAKind' => [],
        ];
        $this->assertEquals($expected, $simulator->handTypes);
    }

    public function testResultCalculation()
    {
        $hands = [
            'highCard' => [new Hand('23456', 10)],
            'pair' => [
                new Hand('AA234', 20),
                new Hand('AA234', 20)
            ],
            'twoPair' => [],
            'threeOfAKind' => [new Hand('AAA34', 30)],
            'fullHouse' => [],
            'fourOfAKind' => [],
            'fiveOfAKind' => [new Hand('AAAAA', 40)]
        ];
        $expected = 10 + 2 * 20 + 3 * 20 + 4 * 30 + 5 * 40;
        $simulator = new Simulator([]);
        $simulator->handTypes = $hands;
        $this->assertEquals($expected, $simulator->calculateResult());
    }

    public function testRankingAlgorithm()
    {
        $simulator = new Simulator([]);
        $simulator->handTypes = [
            'highCard' => [new Hand('23456', 10)],
            'pair' => [
                new Hand('AA435', 20),
                new Hand('AA234', 20)
            ],
            'twoPair' => [
                new Hand('AA445', 20),
                new Hand('JJ335', 20),
                new Hand('K3K36', 20),
            ],
            'threeOfAKind' => [new Hand('AAA34', 30)],
            'fullHouse' => [],
            'fourOfAKind' => [],
            'fiveOfAKind' => [new Hand('AAAAA', 40)]
        ];
        $expected = [
            'fiveOfAKind' => [new Hand('AAAAA', 40)],
            'highCard' => [new Hand('23456', 10)],
            'fourOfAKind' => [],
            'pair' => [
                new Hand('AA234', 20),
                new Hand('AA435', 20)
            ],
            'fullHouse' => [],
            'twoPair' => [
                new Hand('JJ335', 20),
                new Hand('K3K36', 20),
                new Hand('AA445', 20),
            ],
            'threeOfAKind' => [new Hand('AAA34', 30)],
        ];
        $simulator->rankHandTypes();
        $this->assertEquals($expected, $simulator->handTypes);
    }

    public function testHandRankingAlgorithmCanHandleJokers()
    {
        $simulator = new Simulator([]);
        $simulator->handTypes = [
            'highCard' => [new Hand('23456', 10)],
            'pair' => [
                new Hand('AA435', 20),
                new Hand('AA234', 20)
            ],
            'twoPair' => [],
            'threeOfAKind' => [new Hand('AAA34', 30)],
            'fullHouse' => [],
            'fourOfAKind' => [
                new Hand('A44JJ', 40),
                new Hand('A333J', 40),
            ],
            'fiveOfAKind' => [new Hand('AAAAA', 40)]
        ];
        $expected = [
            'fiveOfAKind' => [new Hand('AAAAA', 40)],
            'highCard' => [new Hand('23456', 10)],
            'fourOfAKind' => [
                new Hand('A333J', 40),
                new Hand('A44JJ', 40),
            ],
            'pair' => [
                new Hand('AA234', 20),
                new Hand('AA435', 20)
            ],
            'fullHouse' => [],
            'twoPair' => [],
            'threeOfAKind' => [new Hand('AAA34', 30)],
        ];
        $simulator->rankHandTypes(true);
        $this->assertEquals($expected, $simulator->handTypes);
    }

    public function testSampleInputWithJokers()
    {
        $filePath = __DIR__ . '/files/07-sample.txt';
        $expected = 5905;
        $this->assertSame($expected, (new Solution())->solve(2, $filePath));
    }

    /**
     * @dataProvider jokerHandsDataProvider
     */
    public function testHandTypesWithJokers(string $handType, string $hand)
    {
        $this->assertSame(
            $handType,
            (new Simulator([]))->getTypeForHand($hand, true)
        );
    }

    public static function jokerHandsDataProvider(): array
    {
        return [
            ['fiveOfAKind', 'AAAAA'],
            ['fiveOfAKind', 'AAAAJ'],
            ['fiveOfAKind', 'AAAJJ'],
            ['fiveOfAKind', 'AAJJJ'],
            ['fiveOfAKind', 'AJJJJ'],
            ['fiveOfAKind', 'JJJJJ'],
            ['fourOfAKind', 'AAAA2'],
            ['fourOfAKind', 'AAAJ2'],
            ['fourOfAKind', 'AAJJ2'],
            ['fourOfAKind', 'AJJJ2'],
            ['fullHouse', 'AAAKK'],
            ['threeOfAKind', 'AAA23'],
            ['twoPair', 'AA223'],
            ['pair', 'AA234'],
            ['pair', 'AJ234'],

        ];
    }
}