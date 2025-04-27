<?php

declare(strict_types=1);

namespace App;

final readonly class PuzzleSolver
{
    public function solve(string $puzzleContext): string
    {
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);

        $puzzleSolutionIndex = self::buildPuzzleSolutionRecursively($puzzleDashboard);

        return PuzzleSolution::format($puzzleSolutionIndex);
    }

    private static function buildPuzzleSolutionRecursively(PuzzleDashboard $puzzleDashboard): ?PuzzleSolution
    {
        if ($puzzleDashboard->isSolved()) {
            return $puzzleDashboard->puzzleSolution;
        }
        foreach ($puzzleDashboard->puzzlePieces as $puzzlePiece) {
            if (!$puzzleDashboard->canPuzzlePieceBeAdded($puzzlePiece)) {
                continue;
            }

            $puzzleDashboard->addPuzzlePiece($puzzlePiece);
            $puzzleSolution = self::buildPuzzleSolutionRecursively($puzzleDashboard);
            if ($puzzleSolution) {
                return $puzzleSolution;
            }
            $puzzleDashboard->removePuzzlePiece($puzzlePiece);
        }

        return null;
    }
}
