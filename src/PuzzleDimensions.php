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

    public static function parse(string $puzzleMeasurements): self
    {
        $splitPuzzleMeasurements = explode(' ', $puzzleMeasurements);
        $puzzleHeight = (int) $splitPuzzleMeasurements[0];
        $puzzleWidth = (int) $splitPuzzleMeasurements[1];

        return new self($puzzleHeight, $puzzleWidth);
    }
}
