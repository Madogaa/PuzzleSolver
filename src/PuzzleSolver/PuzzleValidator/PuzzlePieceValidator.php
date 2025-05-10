<?php

declare(strict_types=1);

namespace App\PuzzleSolver\PuzzleValidator;

use App\PuzzleSolver\PuzzlePiece\PuzzlePiece;
use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;

final readonly class PuzzlePieceValidator
{
    private OneRowPuzzlePieceValidator $oneRowPuzzlePieceValidator;
    private MultipleRowsPuzzlePieceValidator $multipleRowsPuzzlePieceValidator;
    public function __construct()
    {
        $this->oneRowPuzzlePieceValidator = new OneRowPuzzlePieceValidator();
        $this->multipleRowsPuzzlePieceValidator = new MultipleRowsPuzzlePieceValidator();
    }
    public function canPuzzlePieceBeAddedToSolutionRotating(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        if ($this->canPuzzlePieceBeAddedToSolution($puzzleSolution, $puzzlePiece)) {
            return true;
        }

        if ($puzzlePiece->getRotationsCount() <= PuzzlePiece::MAX_ROTATIONS) {
            $puzzlePiece->rotate();
            $canBeAdded = $this->canPuzzlePieceBeAddedToSolutionRotating($puzzleSolution, $puzzlePiece);
            if ($canBeAdded) {
                return true;
            }
        }

        return false;
    }

    private function canPuzzlePieceBeAddedToSolution(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        if ($puzzleSolution->isOneRowPuzzle()) {
            return $this->oneRowPuzzlePieceValidator->canPuzzlePieceBeAddedToSolution($puzzleSolution, $puzzlePiece);
        }

        return $this->multipleRowsPuzzlePieceValidator->canPuzzlePieceBeAddedToSolution($puzzleSolution, $puzzlePiece);
    }
}
