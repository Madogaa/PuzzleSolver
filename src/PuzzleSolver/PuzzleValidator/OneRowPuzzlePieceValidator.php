<?php

declare(strict_types=1);

namespace App\PuzzleSolver\PuzzleValidator;

use App\PuzzleSolver\PuzzlePiece\PuzzlePiece;
use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;

final readonly class OneRowPuzzlePieceValidator
{
    public function canPuzzlePieceBeAddedToSolution(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        $previousPuzzlePiece = $puzzleSolution->getPreviousPiece();

        if (self::isFirstPieceToBeSolved($puzzleSolution)
            && self::isPuzzleLeftEnd($puzzlePiece)
        ) {
            return true;
        }

        if (
            self::isPieceToBeSolvedInFirstRowMiddle($puzzleSolution)
            && self::isMiddleRowPuzzlePiece($puzzlePiece)
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
        ) {
            return true;
        }

        if (
            self::isPieceToBeSolvedInRightEnd($puzzleSolution)
            && self::isPuzzleRightEnd($puzzlePiece)
            && $previousPuzzlePiece->matchHorizontally($puzzlePiece)
        ) {
            return true;
        }

        return false;
    }

    private static function isPieceToBeSolvedInFirstRowMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstRow()
            && !self::isFirstPieceToBeSolved($puzzleSolution)
            && !self::isPieceToBeSolvedInRightEnd($puzzleSolution);
    }

    private static function isPuzzleLeftEnd(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder() && $puzzlePiece->hasBottomBorder() && $puzzlePiece->hasLeftBorder();
    }

    private static function isMiddleRowPuzzlePiece(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder() && $puzzlePiece->hasBottomBorder();
    }

    private static function isPuzzleRightEnd(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder() && $puzzlePiece->hasBottomBorder() && $puzzlePiece->hasRightBorder();
    }

    private static function isPieceToBeSolvedInRightEnd(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInLastColumn();
    }

    private static function isFirstPieceToBeSolved(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstColumn();
    }
}
