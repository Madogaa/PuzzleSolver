<?php

declare(strict_types=1);

namespace App\PuzzleSolver\PuzzleValidator;

use App\PuzzleSolver\PuzzlePiece\PuzzlePiece;
use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;

final readonly class PuzzlePieceValidator
{
    private OneRowPuzzlePieceValidator $oneRowPuzzlePieceValidator;

    private OneColumnPuzzlePieceValidator $oneColumnPuzzlePieceValidator;
    private QuadraticPuzzlePieceValidator $multipleRowsPuzzlePieceValidator;
    public function __construct()
    {
        $this->oneRowPuzzlePieceValidator = new OneRowPuzzlePieceValidator();
        $this->multipleRowsPuzzlePieceValidator = new QuadraticPuzzlePieceValidator();
        $this->oneColumnPuzzlePieceValidator = new OneColumnPuzzlePieceValidator();
    }

    public function canPuzzlePieceBeAddedToSolution(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        if ($puzzleSolution->isOneRowPuzzle()) {
            return $this->oneRowPuzzlePieceValidator->canPuzzlePieceBeAddedToSolution($puzzleSolution, $puzzlePiece);
        }

        if ($puzzleSolution->isOneColumnPuzzle()) {
            return $this->oneColumnPuzzlePieceValidator->canPuzzlePieceBeAddedToSolution($puzzleSolution, $puzzlePiece);
        }

        return $this->multipleRowsPuzzlePieceValidator->canPuzzlePieceBeAddedToSolution($puzzleSolution, $puzzlePiece);
    }
}
