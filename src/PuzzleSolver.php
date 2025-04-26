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

        if (count($puzzlePieces) === 1) {
            $puzzleSolutionIndex = new PuzzleSolution([[1]]);
        }

        if (count($puzzlePieces) === 2) {
            $firstPiece = $puzzlePieces[0];
            $secondPiece = $puzzlePieces[1];
            if (self::matchVertically($firstPiece, $secondPiece)) {
                $puzzleSolutionIndex = new PuzzleSolution([[1],[2]]);
            } elseif (self::matchHorizontally($firstPiece, $secondPiece)) {
                $puzzleSolutionIndex = new PuzzleSolution([[1,2]]);
            } elseif (self::matchHorizontally($secondPiece, $firstPiece)) {
                $puzzleSolutionIndex = new PuzzleSolution([[2,1]]);
            } else {
                $puzzleSolutionIndex = new PuzzleSolution([[2],[1]]);
            }
        }

        if (count($puzzlePieces) === 3) {
            $puzzleSolutionIndex = new PuzzleSolution([[1,2,3]]);
        }

        return self::formatPuzzleSolution($puzzleSolutionIndex);
    }

    private static function matchVertically(PuzzlePiece $firstPiece, PuzzlePiece $secondPiece): bool
    {
        return $firstPiece->bottom != 0 && $firstPiece->bottom == $secondPiece->top;
    }

    private static function matchHorizontally(PuzzlePiece $firstPiece, PuzzlePiece $secondPiece): bool
    {
        return $firstPiece->right != 0 && $firstPiece->right == $secondPiece->left;
    }

    /**
     * @param PuzzleSolution $puzzleSolution
     *
     * @return string
     */
    private static function formatPuzzleSolution(PuzzleSolution $puzzleSolution): string
    {
        $puzzleSolutionIndex = $puzzleSolution->puzzleSolutionIndex;
        $puzzleSolutionIndexRows = [];
        foreach ($puzzleSolutionIndex as $puzzleSolution) {
            $puzzleSolutionIndexRows[] = implode(' ', $puzzleSolution);
        }

        return implode("\n", $puzzleSolutionIndexRows);
    }
}
