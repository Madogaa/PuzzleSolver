<?php

declare(strict_types=1);

namespace App;

use function count;

final readonly class PuzzleSolver
{
    public function solve(string $puzzleContext): string
    {
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);

        $puzzleSolutionIndex = self::buildPuzzleSolution($puzzleDashboard);

        return PuzzleSolution::format($puzzleSolutionIndex);
    }

    private static function buildPuzzleSolution(PuzzleDashboard $puzzleDashboard): ?PuzzleSolution
    {
        $puzzlePieces = $puzzleDashboard->puzzlePieces;

        if (count($puzzlePieces) === 1) {
            $puzzleDashboard->addPuzzlePiece($puzzlePieces[0]);
            return $puzzleDashboard->puzzleSolution;
        }

        if (count($puzzlePieces) === 2) {
            $firstPiece = $puzzlePieces[0];
            $secondPiece = $puzzlePieces[1];

            if ($puzzleDashboard->canPuzzlePieceBeAdded($firstPiece)) {
                $puzzleDashboard->addPuzzlePiece($firstPiece);
                if ($puzzleDashboard->canPuzzlePieceBeAdded($secondPiece)) {
                    $puzzleDashboard->addPuzzlePiece($secondPiece);
                    return $puzzleDashboard->puzzleSolution;
                }
                $puzzleDashboard->removePuzzlePiece($firstPiece);
            }

            $puzzleDashboard->addPuzzlePiece($secondPiece);
            $puzzleDashboard->addPuzzlePiece($firstPiece);
            return $puzzleDashboard->puzzleSolution;
        }

        if (count($puzzlePieces) === 3) {
            $puzzleDashboard->addPuzzlePiece($puzzlePieces[0]);
            $puzzleDashboard->addPuzzlePiece($puzzlePieces[1]);
            $puzzleDashboard->addPuzzlePiece($puzzlePieces[2]);
            return $puzzleDashboard->puzzleSolution;
        }

        return null;
    }
}
