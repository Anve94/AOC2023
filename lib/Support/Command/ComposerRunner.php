<?php

declare(strict_types=1);

namespace Support\Command;

use App\BaseSolution;
use Composer\Script\Event as ComposerEvent;
use InvalidArgumentException;

class ComposerRunner
{
    public static function solve(ComposerEvent $event)
    {
        $args = $event->getArguments();
        static::guardArgumentInput($args);

        [$day, $part] = [$args[0], (int) $args[1]];

        /** @var BaseSolution $solutionClass */
        $solutionClass = "\\App\\Day$day\\Solution";
        $solution = new $solutionClass();
        $inputFilePath = __DIR__ . "/../../../src/Day$day/input.txt";
        echo($solution->solve($part, $inputFilePath) . PHP_EOL);
    }

    private static function guardArgumentInput(array $args)
    {
        if (sizeof($args) !== 2) {
            throw new InvalidArgumentException('Please provide a valid day and part');
        }

        [$day, $part] = [$args[0], (int) $args[1]];

        if (!is_numeric($day) || !is_numeric($part)) {
            throw new InvalidArgumentException('Please provide a valid day and part');
        }

        if ((int) $day < 0 || (int) $day > 24) {
            throw new InvalidArgumentException('It\'s called ADVENT of code for a reason... Pick a day 1-24.');
        }

        if ($part !== 1 && $part !== 2) {
            throw new InvalidArgumentException('I know, we really love puzzles. There\'s only two parts though, so pick either 1 or 2');
        }
    }
}
