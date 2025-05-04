<?php

declare(strict_types=1);

namespace App;

use App\Shared\AppLogger;

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

    /**
     * @param PuzzleSolution $puzzleSolution
     *
     * @return bool
     */
    public function isPieceToBeSolvedInMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return !$puzzleSolution->isFirstPieceToBeSolved() && !$puzzleSolution->isPieceToBeSolvedInFirstRow() && !$puzzleSolution->isPieceToBeSolvedInFirstColumn();
    }

    private function canPuzzlePieceBeAddedToSolution(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        $previousPuzzlePiece = $puzzleSolution->getPreviousPiece();
        $topPuzzlePiece = $puzzleSolution->getTopPuzzlePiece();

        if ($puzzleSolution->isFirstPieceToBeSolved() && $puzzlePiece->isFirstCorner()) {
            return true;
        }

        if (
            $this->isPieceInFirstRowAndNotFirstToBeSolved($puzzleSolution)
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
            && $puzzlePiece->hasTopBorder()
        ) {
            return true;
        }

        if ($this->isPieceInFirstColumnAndNotFirstToBeSolved($puzzleSolution) && $topPuzzlePiece->matchVertically($puzzlePiece)) {
            return true;
        }

        if (
            $this->isPieceToBeSolvedInMiddle($puzzleSolution)
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
        ) {
            return true;
        }

        AppLogger::getLogger()->info("Piece {$puzzlePiece} cannot be added context: Top: {$topPuzzlePiece}, Prev: {$previousPuzzlePiece}");

        return false;
    }

    private function isPieceInFirstRowAndNotFirstToBeSolved(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstRow() && !$puzzleSolution->isFirstPieceToBeSolved();
    }

    private function isPieceInFirstColumnAndNotFirstToBeSolved(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstColumn() && !$puzzleSolution->isFirstPieceToBeSolved();
    }
}
