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
        $previousPuzzlePiece = $this->getPreviousPuzzlePiece($puzzleSolution);
        $topPuzzlePiece = $this->getTopPuzzlePiece($puzzleSolution);
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

    private function getPreviousPuzzlePiece(PuzzleSolution $puzzleSolution): ?PuzzlePiece
    {
        $previousPuzzlePieceId = $puzzleSolution->getPuzzleSolutionPreviousPiece();

        return $previousPuzzlePieceId ?? null;
    }

    private function getTopPuzzlePiece(PuzzleSolution $puzzleSolution): ?PuzzlePiece
    {
        $topPuzzlePieceId = $puzzleSolution->getTopPuzzlePiece();

        return $topPuzzlePieceId ?? null;
    }
}
