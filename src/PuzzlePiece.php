<?php

declare(strict_types=1);

namespace App;

final readonly class PuzzlePiece
{
    public function __construct(
        public int $top,
        public int $right,
        public int $bottom,
        public int $left
    ) {
    }

    public static function parse(string $pieceAsString): self
    {
        $pieceShapes = explode(' ', $pieceAsString);
        return new self(
            (int) $pieceShapes[0],
            (int) $pieceShapes[1],
            (int) $pieceShapes[2],
            (int) $pieceShapes[3]
        );
    }
}
