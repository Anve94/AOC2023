<?php

declare(strict_types=1);

namespace Algorithm\Coordinate;

/**
 * Class Point.
 *
 * Coordinate point that can be used in 2 dimensional data structure.
 * This is notably NOT a cartesian point written as (x, y) but instead a table point similar to a spreadsheet.
 * Horizontal lines are row indices and vertical lines are column indices.
 *
 * @author      Stefan Boonstra <s.boonstra@youweagency.com>
 * @copyright   Copyright (c) 2023 Youwe B.V. (https://www.youweagency.com)
 */
class Point
{
    public function __construct(private readonly int $row, private readonly int $col, private readonly string $val) {}

    public function getRow(): int
    {
        return $this->row;
    }

    public function getCol(): int
    {
        return $this->col;
    }

    public function getVal(): string
    {
        return $this->val;
    }
}