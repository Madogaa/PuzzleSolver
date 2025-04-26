<?php

declare(strict_types=1);

namespace App;

use function array_slice;

final readonly class PuzzleConfiguration
{
    /**
     * @param PuzzlePiece[] $puzzlePieces
     */
    private function __construct(
        public array $puzzlePieces
    ) {
    }

    public static function parse(string $puzzleContext): self
    {
        $splitPuzzleContext = explode("\n", $puzzleContext);
        $puzzlePieces = array_slice($splitPuzzleContext, 1);

        return new self(
            array_map(
                static fn (string $puzzlePieceAsString) => PuzzlePiece::parse($puzzlePieceAsString),
                $puzzlePieces
            )
        );
    }
}
