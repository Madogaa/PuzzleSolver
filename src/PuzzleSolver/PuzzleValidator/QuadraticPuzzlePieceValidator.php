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
            self::isPieceToBeSolvedInFirstRowMiddle($puzzleSolution)
            && self::isFirstRowInMiddle($puzzlePiece)
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
        ) {
            return true;
        }

        if (
            self::isPieceToBeSolvedInRightTopCorner($puzzleSolution)
            && self::isRightTopCorner($puzzlePiece)
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
        ) {
            return true;
        }

        if (
            self::isPieceToBeSolvedInFirstColumnMiddle($puzzleSolution)
            && self::isInFirstColumnMiddle($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
        ) {
            return true;
        }

        if (
            self::isPieceToBeSolvedInMiddle($puzzleSolution)
            && self::isMiddlePiece($puzzlePiece)
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
        ) {
            return true;
        }

        if (
            self::isPieceToBeSolvedInLastColumnMiddle($puzzleSolution)
            && self::isLastColumnMiddle($puzzlePiece)
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
        ) {
            return true;
        }

        if (
            $puzzleSolution->isPieceToBeSolvedBottomEnd()
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

        if (
            self::isPieceToBeSolvedRightBottomCorner($puzzleSolution)
            && self::rightBottomCorner($puzzlePiece)
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
        ) {
            return true;
        }

        return false;
    }

    private static function isPieceToBeSolvedInFirstRowMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstRow()
            && !$puzzleSolution->isFirstPieceToBeSolved()
            && !self::isPieceToBeSolvedInRightTopCorner($puzzleSolution);
    }

    private static function isPieceToBeSolvedInFirstColumnMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstColumn()
            && !$puzzleSolution->isFirstPieceToBeSolved()
            && !$puzzleSolution->isPieceToBeSolvedBottomEnd();
    }
    private static function isPieceToBeSolvedInMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return !$puzzleSolution->isPieceToBeSolvedInFirstRow()
            && !$puzzleSolution->isPieceToBeSolvedInFirstColumn()
            && !$puzzleSolution->isPieceToBeSolvedInLastRow()
            && !$puzzleSolution->isPieceToBeSolvedInLastColumn();
    }

    private function isLeftTopCorner(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder() && $puzzlePiece->hasLeftBorder()
            && !$puzzlePiece->hasRightBorder() && !$puzzlePiece->hasBottomBorder();
    }

    private function isFirstRowInMiddle(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder()
            && !$puzzlePiece->hasRightBorder() && !$puzzlePiece->hasBottomBorder() && !$puzzlePiece->hasLeftBorder();
    }

    private static function isRightTopCorner(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder() && $puzzlePiece->hasRightBorder()
            && !$puzzlePiece->hasBottomBorder() && !$puzzlePiece->hasLeftBorder();
    }

    private static function isInFirstColumnMiddle(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasLeftBorder()
            && !$puzzlePiece->hasRightBorder() && !$puzzlePiece->hasBottomBorder() && !$puzzlePiece->hasTopBorder();
    }

    private static function isLeftBottomCorner(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasBottomBorder() && $puzzlePiece->hasLeftBorder()
            && !$puzzlePiece->hasRightBorder() && !$puzzlePiece->hasTopBorder();
    }

    private static function isPieceToBeSolvedInLastRowMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInLastRow()
            && !$puzzleSolution->isPieceToBeSolvedBottomEnd()
            && !self::isPieceToBeSolvedRightBottomCorner($puzzleSolution);
    }

    private static function isLastRowMiddle(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasBottomBorder()
            && !$puzzlePiece->hasLeftBorder() && !$puzzlePiece->hasRightBorder() && !$puzzlePiece->hasTopBorder();
    }

    private static function isPieceToBeSolvedRightBottomCorner(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedRightBottomCorner();
    }

    private static function rightBottomCorner(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasBottomBorder() && $puzzlePiece->hasRightBorder()
            && !$puzzlePiece->hasLeftBorder() && !$puzzlePiece->hasTopBorder();
    }

    private static function isPieceToBeSolvedInLastColumnMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInLastColumn()
            && !self::isPieceToBeSolvedInRightTopCorner($puzzleSolution)
            && !self::isPieceToBeSolvedRightBottomCorner($puzzleSolution);
    }

    private static function isLastColumnMiddle(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasRightBorder()
            && !$puzzlePiece->hasLeftBorder() && !$puzzlePiece->hasBottomBorder() && !$puzzlePiece->hasTopBorder();
    }

    private static function isMiddlePiece(PuzzlePiece $puzzlePiece): bool
    {
        return !$puzzlePiece->hasTopBorder() && !$puzzlePiece->hasBottomBorder()
            && !$puzzlePiece->hasLeftBorder() && !$puzzlePiece->hasRightBorder();
    }

    /**
     * @param PuzzleSolution $puzzleSolution
     * @return bool
     */
    private static function isPieceToBeSolvedInRightTopCorner(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInLastColumn() && $puzzleSolution->isPieceToBeSolvedInFirstRow();
    }
}
