<?php

declare(strict_types=1);

namespace App\PuzzleSolver\PuzzleValidator;

use App\PuzzleSolver\PuzzlePiece\PuzzlePiece;
use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;

final readonly class PuzzlePieceValidator
{
    public static function canPuzzlePieceBeAddedToSolution(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        if ($puzzleSolution->isOneRowPuzzle()) {
            return OneRowPuzzlePieceValidator::canPuzzlePieceBeAddedToSolution($puzzleSolution, $puzzlePiece);
        }

        if ($puzzleSolution->isOneColumnPuzzle()) {
            return OneColumnPuzzlePieceValidator::canPuzzlePieceBeAddedToSolution($puzzleSolution, $puzzlePiece);
        }

        return QuadraticPuzzlePieceValidator::canPuzzlePieceBeAddedToSolution($puzzleSolution, $puzzlePiece);
    }
}
