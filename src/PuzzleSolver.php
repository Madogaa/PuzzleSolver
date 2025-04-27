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
        $puzzleSolution = new PuzzleSolution([]);

        if (count($puzzlePieces) === 1) {
            $puzzleSolution->addPuzzlePieceAtNewRow($puzzlePieces[0]);
            return $puzzleSolution;
        }

        if (count($puzzlePieces) === 2) {
            $firstPiece = $puzzlePieces[0];
            $secondPiece = $puzzlePieces[1];
            if ($firstPiece->matchVertically($secondPiece)) {
                $puzzleDashboard->addPuzzlePiece($puzzleSolution, $firstPiece);
                $puzzleDashboard->addPuzzlePiece($puzzleSolution, $secondPiece);
                return $puzzleSolution;
            }
            if ($firstPiece->matchHorizontally($secondPiece)) {
                $puzzleDashboard->addPuzzlePiece($puzzleSolution, $firstPiece);
                $puzzleDashboard->addPuzzlePiece($puzzleSolution, $secondPiece);
                return $puzzleSolution;
            }
            if ($secondPiece->matchHorizontally($firstPiece)) {
                $puzzleDashboard->addPuzzlePiece($puzzleSolution, $secondPiece);
                $puzzleDashboard->addPuzzlePiece($puzzleSolution, $firstPiece);
                return $puzzleSolution;
            }

            $puzzleDashboard->addPuzzlePiece($puzzleSolution, $secondPiece);
            $puzzleDashboard->addPuzzlePiece($puzzleSolution, $firstPiece);
            return $puzzleSolution;
        }

        if (count($puzzlePieces) === 3) {
            $puzzleDashboard->addPuzzlePiece($puzzleSolution, $puzzlePieces[0]);
            $puzzleDashboard->addPuzzlePiece($puzzleSolution, $puzzlePieces[1]);
            $puzzleDashboard->addPuzzlePiece($puzzleSolution, $puzzlePieces[2]);
            return $puzzleSolution;
        }

        return null;
    }
}
