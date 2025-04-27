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
            if ($firstPiece->matchVertically($secondPiece)) {
                $puzzleDashboard->addPuzzlePiece($firstPiece);
                $puzzleDashboard->addPuzzlePiece($secondPiece);
                return $puzzleDashboard->puzzleSolution;
            }
            if ($firstPiece->matchHorizontally($secondPiece)) {
                $puzzleDashboard->addPuzzlePiece($firstPiece);
                $puzzleDashboard->addPuzzlePiece($secondPiece);
                return $puzzleDashboard->puzzleSolution;
            }
            if ($secondPiece->matchHorizontally($firstPiece)) {
                $puzzleDashboard->addPuzzlePiece($secondPiece);
                $puzzleDashboard->addPuzzlePiece($firstPiece);
                return $puzzleDashboard->puzzleSolution;
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
