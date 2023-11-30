<?php

declare(strict_types=1);

namespace Support\Api;

interface InputParserInterface
{
    /**
     * Get array where every line in a file is a string representation of the entire line.
     *
     * @param string $filePath
     * @return string[]
     */
    public static function parseFileAsArraySplitOnLines(string $filePath): array;

}