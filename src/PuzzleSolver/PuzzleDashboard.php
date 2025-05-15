<?php

declare(strict_types=1);

namespace App\PuzzleSolver;

use App\PuzzleSolver\PuzzlePiece\PuzzlePiece;
use App\PuzzleSolver\PuzzleSolution\PuzzleDimensions;
use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;
use App\PuzzleSolver\PuzzleValidator\PuzzlePieceValidator;

use function array_filter;
use function array_slice;

final class PuzzleDashboard
{

    /**
     * @param PuzzlePiece[] $availablePuzzlePieces
     */
    private function __construct(
        public array $availablePuzzlePieces,
        public readonly PuzzleSolution $puzzleSolution
    ) {
    }

    public static function parse(string $puzzleContext): self
    {
        $splitPuzzleContext = explode("\n", $puzzleContext);
        $puzzlePiecesAsString = array_slice($splitPuzzleContext, 1);
        $puzzlePieces = array_map(
            static fn (string $puzzlePieceAsString, int $puzzlePiecePosition) => PuzzlePiece::parse($puzzlePieceAsString, $puzzlePiecePosition),
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
}
