<?php

declare(strict_types=1);

namespace App\PuzzleSolver\PuzzlePiece;

use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;

class PuzzlePieceValidator
{
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
        $previousPuzzlePiece = $puzzleSolution->getPreviousPiece();
        $topPuzzlePiece = $puzzleSolution->getTopPuzzlePiece();

        if ($puzzleSolution->isPieceToBeSolvedLeftTopCorner() && $puzzlePiece->isFirstCorner()) {
            return true;
        }

        if (
            $this->isPieceToBeSolvedInFirstRowMiddle($puzzleSolution)
            && $puzzlePiece->hasTopBorder()
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
        ) {
            return true;
        }

        if (
            $puzzleSolution->isPieceToBeSolvedInRightTopCorner()
            && $puzzlePiece->isRightTopCorner()
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
        ) {
            return true;
        }

        if (
            $this->isPieceInFirstColumnAndNotFirstToBeSolved($puzzleSolution)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
            && $puzzlePiece->hasLeftBorder()
        ) {
            return true;
        }

        if (
            $this->isPieceToBeSolvedInMiddle($puzzleSolution)
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
        ) {
            return true;
        }

        return false;
    }

    private function isPieceToBeSolvedInFirstRowMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstRow()
            && !$puzzleSolution->isPieceToBeSolvedLeftTopCorner()
            && !$puzzleSolution->isPieceToBeSolvedInRightTopCorner();
    }

    private function isPieceInFirstColumnAndNotFirstToBeSolved(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstColumn() && !$puzzleSolution->isPieceToBeSolvedLeftTopCorner();
    }
    private function isPieceToBeSolvedInMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return !$puzzleSolution->isPieceToBeSolvedInFirstRow() && !$puzzleSolution->isPieceToBeSolvedInFirstColumn();
    }
}
