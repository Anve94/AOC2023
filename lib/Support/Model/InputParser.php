<?php

declare(strict_types=1);

namespace Support\Model;

use Algorithm\Coordinate\Point;
use InvalidArgumentException;

class InputParser
{
    public const EOL_REGEX = "/\\r\\n|\\r|\\n/";

    /**
     * Get array where every line in a file is a string representation of the entire line.
     *
     * @throws InvalidArgumentException
     */
    public static function parseFileAsArraySplitOnLines(string $filePath): array
    {
        static::validateFileExists($filePath);

        $data = file_get_contents($filePath);
        return preg_split(self::EOL_REGEX, $data);
    }

    public static function parseAsTwoDimensionalArray(string $filePath): array
    {
        static::validateFileExists($filePath);

        return array_map('str_split', self::parseFileAsArraySplitOnLines($filePath));
    }

    /**
     * @param string $filePath
     * @return array<Point[]>
     */
    public static function parseAsTwoDimensionalCoordinatesArray(string $filePath): array
    {
        $data = self::parseAsTwoDimensionalArray($filePath);
        $points = [];
        foreach ($data as $rowIndex => $row) {
            foreach ($row as $colIndex => $value) {
                $points[$rowIndex][$colIndex] = new Point($rowIndex, $colIndex, $value);
            }
        }

        return $points;
    }

    private static function validateFileExists(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new InvalidArgumentException(
                sprintf(
                    'File does not exist. Did you pass the correct filePath? Received: %s ',
                    $filePath
                )
            );
        }
    }
}
