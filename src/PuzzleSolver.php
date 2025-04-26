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
            $firstPiece = $puzzlePieces[0];
            return new PuzzleSolution([[$firstPiece->id]]);
        }

        if (count($puzzlePieces) === 2) {
            $firstPiece = $puzzlePieces[0];
            $secondPiece = $puzzlePieces[1];
            if ($firstPiece->matchVertically($secondPiece)) {
                return new PuzzleSolution([[$firstPiece->id],[$secondPiece->id]]);
            } elseif ($firstPiece->matchHorizontally($secondPiece)) {
                return new PuzzleSolution([[$firstPiece->id,$secondPiece->id]]);
            } elseif ($secondPiece->matchHorizontally($firstPiece)) {
                return new PuzzleSolution([[$secondPiece->id,$firstPiece->id]]);
            }
            return new PuzzleSolution([[$secondPiece->id],[$firstPiece->id]]);
        }

        if (count($puzzlePieces) === 3) {
            $firstPiece = $puzzlePieces[0];
            $secondPiece = $puzzlePieces[1];
            $thirdPiece = $puzzlePieces[2];
            return new PuzzleSolution([[$firstPiece->id,$secondPiece->id,$thirdPiece->id]]);
        }

        return null;
    }
}
