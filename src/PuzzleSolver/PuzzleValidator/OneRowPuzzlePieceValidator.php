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

        if ($puzzleSolution->isFirstPieceToBeSolved()
            && self::isPuzzleLeftEnd($puzzlePiece)
        ) {
            return true;
        }

        if (
            $this->isPieceToBeSolvedInFirstRowMiddle($puzzleSolution)
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

    private function isPieceToBeSolvedInFirstRowMiddle(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInFirstRow()
            && !$puzzleSolution->isFirstPieceToBeSolved()
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

    /**
     * @param PuzzleSolution $puzzleSolution
     * @return bool
     */
    private static function isPieceToBeSolvedInRightEnd(PuzzleSolution $puzzleSolution): bool
    {
        return $puzzleSolution->isPieceToBeSolvedInLastColumn();
    }
}
