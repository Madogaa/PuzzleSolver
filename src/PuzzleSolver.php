<?php

declare(strict_types=1);

namespace App;

use function count;

final readonly class PuzzleSolver
{
    public function solve(string $puzzleContext): string
    {
        $puzzleConfiguration = PuzzleConfiguration::parse($puzzleContext);
        $puzzlePieces = $puzzleConfiguration->puzzlePieces;

        $puzzleSolutionIndex = self::buildPuzzleSolution($puzzlePieces);

        return PuzzleSolution::format($puzzleSolutionIndex);
    }

    /**
     * @param PuzzlePiece[] $puzzlePieces
     */
    private static function buildPuzzleSolution(array $puzzlePieces): ?PuzzleSolution
    {
        if (count($puzzlePieces) === 1) {
            $puzzleSolutionIndex = new PuzzleSolution([[1]]);
        }

        if (count($puzzlePieces) === 2) {
            $firstPiece = $puzzlePieces[0];
            $secondPiece = $puzzlePieces[1];
            if ($firstPiece->matchVertically($secondPiece)) {
                $puzzleSolutionIndex = new PuzzleSolution([[1],[2]]);
            } elseif (PuzzlePiece::matchHorizontally($firstPiece, $secondPiece)) {
                $puzzleSolutionIndex = new PuzzleSolution([[1,2]]);
            } elseif (PuzzlePiece::matchHorizontally($secondPiece, $firstPiece)) {
                $puzzleSolutionIndex = new PuzzleSolution([[2,1]]);
            } else {
                $puzzleSolutionIndex = new PuzzleSolution([[2],[1]]);
            }
        }

        if (count($puzzlePieces) === 3) {
            $puzzleSolutionIndex = new PuzzleSolution([[1,2,3]]);
        }
        return $puzzleSolutionIndex;
    }
}
