<?php

declare(strict_types=1);

namespace App;

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

        $isFirstPieceToPlace = !$previousPuzzlePiece && !$topPuzzlePiece;
        if ($isFirstPieceToPlace && $puzzlePiece->isFirstCorner()) {
            return true;
        }

        if (!$topPuzzlePiece && $previousPuzzlePiece && $previousPuzzlePiece->matchHorizontally($puzzlePiece)) {
            return true;
        }

        if (!$previousPuzzlePiece && $topPuzzlePiece && $topPuzzlePiece->matchVertically($puzzlePiece)) {
            return true;
        }

        if (
            $previousPuzzlePiece
            && $topPuzzlePiece
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
        ) {
            return true;
        }

        return false;
    }
}
