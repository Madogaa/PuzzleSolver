<?php

declare(strict_types=1);

namespace App;

use function array_slice;

final readonly class PuzzleConfiguration
{
    private const int PUZZLE_PIECES_INDEX_OFFSET = 1;

    /**
     * @param PuzzlePiece[] $puzzlePieces
     */
    private function __construct(
        public array $puzzlePieces,
        private int $heigh,
        private int $width
    ) {
    }

    public static function parse(string $puzzleContext): self
    {
        $splitPuzzleContext = explode("\n", $puzzleContext);
        $puzzleMeasurements = $splitPuzzleContext[0];
        $splitPuzzleMeasurements = explode(' ', $puzzleMeasurements);
        $puzzleHeight = (int) $splitPuzzleMeasurements[0];
        $puzzleWidth = (int) $splitPuzzleMeasurements[1];
        $puzzlePieces = array_slice($splitPuzzleContext, 1);

        return new self(
            array_map(
                static fn (string $puzzlePieceAsString, int $puzzlePiecePosition) => PuzzlePiece::parse($puzzlePieceAsString, $puzzlePiecePosition + self::PUZZLE_PIECES_INDEX_OFFSET),
                $puzzlePieces,
                array_keys($puzzlePieces)
            ),
            $puzzleHeight,
            $puzzleWidth
        );
    }
}
