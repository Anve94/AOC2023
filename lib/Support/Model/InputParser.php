<?php

declare(strict_types=1);

namespace Support\Model;

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
