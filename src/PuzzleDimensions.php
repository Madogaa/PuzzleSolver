<?php

declare(strict_types=1);

namespace App;

final readonly class PuzzleDimensions
{
    public function __construct(
        public int $heigh,
        public int $width
    ) {
    }
}
