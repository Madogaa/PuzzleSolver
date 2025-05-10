<?php

declare(strict_types=1);

namespace App\PuzzleSolver\PuzzleValidator;

use App\PuzzleSolver\PuzzlePiece\PuzzlePiece;
use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;

class OneColumnPuzzlePieceValidator
{
    public function canPuzzlePieceBeAddedToSolution(PuzzleSolution $puzzleSolution, PuzzlePiece $puzzlePiece): bool
    {
        $topPuzzlePiece = $puzzleSolution->getTopPuzzlePiece();

        if (
            $puzzleSolution->isFirstPieceToBeSolved()
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
            $puzzleSolution->isPieceToBeSolvedBottomEnd()
            && self::isBottomEndPiece($puzzlePiece)
            && $topPuzzlePiece->matchVertically($puzzlePiece)
        ) {
            return true;
        }

        return false;
    }

    private static function isPieceToBeSolvedInMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstColumn()
            && !$puzzleSolution->isFirstPieceToBeSolved()
            && !$puzzleSolution->isPieceToBeSolvedBottomEnd();
    }

    private function isTopEndPiece(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasTopBorder() && $puzzlePiece->hasLeftBorder();
    }

    private static function isMiddlePiece(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasLeftBorder();
    }

    private static function isBottomEndPiece(PuzzlePiece $puzzlePiece): bool
    {
        return $puzzlePiece->hasBottomBorder() && $puzzlePiece->hasLeftBorder();
    }
}
