<?php

declare(strict_types=1);

namespace App\PuzzleSolver\PuzzleValidator;

use App\PuzzleSolver\PuzzlePiece\PuzzlePiece;
use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;

final readonly class QuadraticPuzzlePieceValidator
{
    public static function canPuzzlePieceBeAddedToSolution(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        $previousPuzzlePiece = $puzzleSolution->getPreviousPiece();
        $topPuzzlePiece = $puzzleSolution->getTopPuzzlePiece();

        if (
            self::isFirstPieceToBeSolved($puzzleSolution)
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
            self::isPieceToBeSolvedInLeftBottomCorner($puzzleSolution)
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

    public static function isPieceToBeSolvedInLastRow(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInLastRow();
    }

    private static function isFirstPieceToBeSolved(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstColumn() && $puzzleSolution->isPieceToBeSolvedInFirstRow();
    }

    private static function isLeftTopCorner(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder() && $puzzlePiece->hasLeftBorder()
            && !$puzzlePiece->hasRightBorder() && !$puzzlePiece->hasBottomBorder();
    }

    private static function isPieceToBeSolvedInFirstRowMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstRow()
            && !self::isFirstPieceToBeSolved($puzzleSolution)
            && !self::isPieceToBeSolvedInRightTopCorner($puzzleSolution);
    }

    private static function isPieceToBeSolvedInRightTopCorner(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInLastColumn() && $puzzleSolution->isPieceToBeSolvedInFirstRow();
    }

    private static function isFirstRowInMiddle(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder()
            && !$puzzlePiece->hasRightBorder() && !$puzzlePiece->hasBottomBorder() && !$puzzlePiece->hasLeftBorder();
    }

    private static function isRightTopCorner(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder() && $puzzlePiece->hasRightBorder()
            && !$puzzlePiece->hasBottomBorder() && !$puzzlePiece->hasLeftBorder();
    }

    private static function isPieceToBeSolvedInFirstColumnMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstColumn()
            && !self::isFirstPieceToBeSolved($puzzleSolution)
            && !self::isPieceToBeSolvedInLeftBottomCorner($puzzleSolution);
    }

    private static function isPieceToBeSolvedInLeftBottomCorner(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInLastRow() && $puzzleSolution->isPieceToBeSolvedInFirstColumn();
    }

    private static function isInFirstColumnMiddle(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasLeftBorder()
            && !$puzzlePiece->hasRightBorder() && !$puzzlePiece->hasBottomBorder() && !$puzzlePiece->hasTopBorder();
    }

    private static function isPieceToBeSolvedInMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return !$puzzleSolution->isPieceToBeSolvedInFirstRow()
            && !$puzzleSolution->isPieceToBeSolvedInFirstColumn()
            && !$puzzleSolution->isPieceToBeSolvedInLastRow()
            && !$puzzleSolution->isPieceToBeSolvedInLastColumn();
    }

    private static function isMiddlePiece(PuzzlePiece $puzzlePiece): bool
    {
        return !$puzzlePiece->hasTopBorder() && !$puzzlePiece->hasBottomBorder()
            && !$puzzlePiece->hasLeftBorder() && !$puzzlePiece->hasRightBorder();
    }

    private static function isPieceToBeSolvedInLastColumnMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInLastColumn()
            && !self::isPieceToBeSolvedInRightTopCorner($puzzleSolution)
            && !self::isPieceToBeSolvedRightBottomCorner($puzzleSolution);
    }

    private static function isPieceToBeSolvedRightBottomCorner(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInLastRow() && $puzzleSolution->isPieceToBeSolvedInLastColumn();
    }

    private static function isLastColumnMiddle(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasRightBorder()
            && !$puzzlePiece->hasLeftBorder() && !$puzzlePiece->hasBottomBorder() && !$puzzlePiece->hasTopBorder();
    }

    private static function isLeftBottomCorner(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasBottomBorder() && $puzzlePiece->hasLeftBorder()
            && !$puzzlePiece->hasRightBorder() && !$puzzlePiece->hasTopBorder();
    }

    private static function isPieceToBeSolvedInLastRowMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return self::isPieceToBeSolvedInLastRow($puzzleSolution)
            && !self::isPieceToBeSolvedInLeftBottomCorner($puzzleSolution)
            && !self::isPieceToBeSolvedRightBottomCorner($puzzleSolution);
    }

    private static function isLastRowMiddle(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasBottomBorder()
            && !$puzzlePiece->hasLeftBorder() && !$puzzlePiece->hasRightBorder() && !$puzzlePiece->hasTopBorder();
    }

    private static function rightBottomCorner(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasBottomBorder() && $puzzlePiece->hasRightBorder()
            && !$puzzlePiece->hasLeftBorder() && !$puzzlePiece->hasTopBorder();
    }
}
