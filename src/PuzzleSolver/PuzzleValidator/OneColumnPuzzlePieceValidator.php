<?php

declare(strict_types=1);

namespace App\PuzzleSolver\PuzzleValidator;

use App\PuzzleSolver\PuzzlePiece\PuzzlePiece;
use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;

class OneColumnPuzzlePieceValidator
{
    public static function canPuzzlePieceBeAddedToSolution(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        $topPuzzlePiece = $puzzleSolution->getTopPuzzlePiece();

        if (
            $puzzleSolution->isPieceToBeSolvedInFirstRow()
            && self::isTopEndPiece($puzzlePiece)
        ) {
            return true;
        }

        if (
            self::isPieceToBeSolvedInMiddle($puzzleSolution)
            && self::isMiddlePiece($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
        ) {
            return true;
        }

        if (
            $puzzleSolution->isPieceToBeSolvedInLastRow()
            && self::isBottomEndPiece($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
        ) {
            return true;
        }

        return false;
    }

    private static function isPieceToBeSolvedInMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return !$puzzleSolution->isPieceToBeSolvedInFirstRow() && !$puzzleSolution->isPieceToBeSolvedInLastRow();
    }

    private static function isTopEndPiece(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder() && $puzzlePiece->hasLeftBorder() && $puzzlePiece->hasRightBorder();
    }

    private static function isMiddlePiece(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasLeftBorder();
    }

    private static function isBottomEndPiece(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasBottomBorder() && $puzzlePiece->hasLeftBorder() && $puzzlePiece->hasRightBorder();
    }
}
