<?php

declare(strict_types=1);

namespace App;

use function array_filter;
use function array_slice;

final class PuzzleDashboard
{
    private const int PUZZLE_PIECES_INDEX_OFFSET = 1;
    private PuzzlePieceValidator $puzzlePieceValidator;

    /**
     * @param PuzzlePiece[] $availablePuzzlePieces
     */
    private function __construct(
        public array $availablePuzzlePieces,
        public readonly PuzzleSolution $puzzleSolution
    ) {
        $this->puzzlePieceValidator = new PuzzlePieceValidator();
    }

    public static function parse(string $puzzleContext): self
    {
        $splitPuzzleContext = explode("\n", $puzzleContext);
        $puzzlePiecesAsString = array_slice($splitPuzzleContext, 1);
        $puzzlePieces = array_map(
            static fn (string $puzzlePieceAsString, int $puzzlePiecePosition) => PuzzlePiece::parse($puzzlePieceAsString, $puzzlePiecePosition + self::PUZZLE_PIECES_INDEX_OFFSET),
            $puzzlePiecesAsString,
            array_keys($puzzlePiecesAsString)
        );
        return new self(
            $puzzlePieces,
            new PuzzleSolution(
                PuzzleDimensions::parse($splitPuzzleContext[0])
            )
        );
    }

    public function addPuzzlePiece(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolution->addPuzzlePiece($puzzlePiece);
        $this->availablePuzzlePieces = array_filter(
            $this->availablePuzzlePieces,
            static fn (PuzzlePiece $availablePuzzlePiece) => $availablePuzzlePiece->id !== $puzzlePiece->id
        );
    }

    public function removePuzzlePiece(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolution->removePuzzlePiece();
        $this->availablePuzzlePieces[] = $puzzlePiece;
    }

    public function canPuzzlePieceBeAddedWithRotations(PuzzlePiece $puzzlePiece): bool
    {
        return $this->puzzlePieceValidator->canPuzzlePieceBeAddedWithRotations($this->puzzleSolution, $puzzlePiece);
    }
}
