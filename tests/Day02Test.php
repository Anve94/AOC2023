<?php

declare(strict_types=1);

namespace App\Test;

use App\Day2\GameParser;
use App\Day2\Solution;
use PHPUnit\Framework\TestCase;

class Day02Test extends TestCase
{
    public function testGameStatesCanBeParsedSuccessfully()
    {
        $data = [
            'Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green',
            'Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue',
        ];
        $game = new GameParser($data);

        $expected = [
            1 => [
                ['blue' => 3, 'red' => 4],
                ['red' => 1, 'green' => 2, 'blue' => 6],
                ['green' => 2]
            ],
            2 => [
                ['blue' => 1, 'green' => 2],
                ['green' => 3, 'blue' => 4, 'red' => 1],
                ['green' => 1, 'blue' => 1]
            ]
        ];

        $this->assertEquals($expected, $game->games);
    }

    public function testNoGameIsInvalid()
    {
        $data = [
            'Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green',
            'Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue',
        ];
        $gameParser = (new GameParser($data))->createGameResultScoring();
        $this->assertSame(3, $gameParser->getSumOfPossibleGames());
    }

    public function testTwoGamesAreInvalid()
    {
        $data = [
            'Game 1: 3 blue, 41 red; 1 red, 2 green, 6 blue; 2 green',
            'Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue',
            'Game 3: 1 blue, 2 green; 33 green, 4 blue, 1 red; 1 green, 1 blue',
        ];
        $gameParser = (new GameParser($data))->createGameResultScoring();
        $this->assertSame(2, $gameParser->getSumOfPossibleGames());
    }

    public function testPart1WithProvidedSampleData()
    {
        $filePath = __DIR__ . '/files/02-example.txt';
        $solution = (new Solution())->solve(1, $filePath);
        $this->assertEquals(8, $solution);
    }

    public function testPart2WithSingleLine()
    {
        $data = [
            'Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green',
        ];
        $powers = (new GameParser($data))->getPowerOfHighestColors();
        $this->assertEquals(48, $powers);
    }

    public function testPart2WithSampleInput()
    {
        $filePath = __DIR__ . '/files/02-example.txt';
        $solution = (new Solution())->solve(2, $filePath);
        $this->assertEquals(2286, $solution);
    }
}