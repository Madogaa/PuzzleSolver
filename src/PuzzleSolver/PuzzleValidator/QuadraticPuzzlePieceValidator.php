<?php

declare(strict_types=1);

namespace App\PuzzleSolver\PuzzleValidator;

use App\PuzzleSolver\PuzzlePiece\PuzzlePiece;
use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;

final readonly class QuadraticPuzzlePieceValidator
{
    public function canPuzzlePieceBeAddedToSolution(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        $previousPuzzlePiece = $puzzleSolution->getPreviousPiece();
        $topPuzzlePiece = $puzzleSolution->getTopPuzzlePiece();

        if (
            $puzzleSolution->isFirstPieceToBeSolved()
            && self::isLeftTopCorner($puzzlePiece)
        ) {
            return true;
        }

        if (
            $this->isPieceToBeSolvedInFirstRowMiddle($puzzleSolution)
            && self::isFirstRowInMiddle($puzzlePiece)
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
        ) {
            return true;
        }

        if (
            $puzzleSolution->isPieceToBeSolvedInRightTopCorner()
            && self::isRightTopCorner($puzzlePiece)
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
        ) {
            return true;
        }

        if (
            $this->isPieceToBeSolvedInFirstColumnMiddle($puzzleSolution)
            && self::isInFirstColumnMiddle($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
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

        if (
            $puzzleSolution->isPieceToBeSolvedLeftBottomCorner()
            && self::isLeftBottomCorner($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
        ) {
            return true;
        }

        if (
            self::isPieceToBeSolvedInLastRowMiddle($puzzleSolution)
            && self::isLastRowMiddle($puzzlePiece)
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
            && !$puzzleSolution->isFirstPieceToBeSolved()
            && !$puzzleSolution->isPieceToBeSolvedInRightTopCorner();
    }

    private function isPieceToBeSolvedInFirstColumnMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstColumn()
            && !$puzzleSolution->isFirstPieceToBeSolved()
            && !$puzzleSolution->isPieceToBeSolvedLeftBottomCorner();
    }
    private function isPieceToBeSolvedInMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return !$puzzleSolution->isPieceToBeSolvedInFirstRow()
            && !$puzzleSolution->isPieceToBeSolvedInFirstColumn()
            && !self::isPieceToBeSolvedInLastRowMiddle($puzzleSolution);
    }

    private function isLeftTopCorner(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder() && $puzzlePiece->hasLeftBorder();
    }

    private function isFirstRowInMiddle(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder();
    }

    private static function isRightTopCorner(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder() && $puzzlePiece->hasRightBorder();
    }

    private static function isInFirstColumnMiddle(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasLeftBorder();
    }

    private static function isLeftBottomCorner(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasBottomBorder() && $puzzlePiece->hasLeftBorder();
    }

    private static function isPieceToBeSolvedInLastRowMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInLastRow()
            && !$puzzleSolution->isPieceToBeSolvedLeftBottomCorner()
            && !$puzzleSolution->isPieceToBeSolvedRightBottomCorner();
    }

    private static function isLastRowMiddle(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasBottomBorder();
    }
}
