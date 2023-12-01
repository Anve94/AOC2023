<?php

declare(strict_types=1);

namespace Support\Model;

use InvalidArgumentException;
use Support\Api\InputParserInterface;

class InputParser implements InputParserInterface
{
    private const EOL_REGEX = "/\\r\\n|\\r|\\n/";

    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public static function parseFileAsArraySplitOnLines(string $filePath): array
    {
        static::validateFileExists($filePath);

        $data = file_get_contents($filePath);
        return preg_split(self::EOL_REGEX, $data);
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