<?php

declare(strict_types=1);

namespace App;

class PuzzlePieceValidator
{
    public function __construct()
    {
    }

    public function canPuzzlePieceBeAddedWithRotations(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        if ($this->canPuzzlePieceBeAdded($puzzleSolution, $puzzlePiece)) {
            return true;
        }

        if ($puzzlePiece->getRotationsCount() <= PuzzlePiece::MAX_ROTATIONS) {
            $puzzlePiece->rotate();
            $canBeAdded = $this->canPuzzlePieceBeAddedWithRotations($puzzleSolution, $puzzlePiece);
            if ($canBeAdded) {
                return true;
            }
        }

        return false;
    }

    private function canPuzzlePieceBeAdded(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        $previousPuzzlePiece = $puzzleSolution->getPuzzleSolutionPreviousPiece();
        $topPuzzlePiece = $puzzleSolution->getTopPuzzlePiece();
        if (!$previousPuzzlePiece && !$topPuzzlePiece) {
            return true;
        }

        if (!$topPuzzlePiece && $previousPuzzlePiece->matchHorizontally($puzzlePiece)) {
            return true;
        }

        if (!$previousPuzzlePiece && $topPuzzlePiece->matchVertically($puzzlePiece)) {
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
