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
        $puzzleSolution = new PuzzleSolution([]);

        if (count($puzzlePieces) === 1) {
            $puzzleSolution->addPuzzlePieceHorizontally($puzzlePieces[0]);
            return $puzzleSolution;
        }

        if (count($puzzlePieces) === 2) {
            $firstPiece = $puzzlePieces[0];
            $secondPiece = $puzzlePieces[1];
            if ($firstPiece->matchVertically($secondPiece)) {
                $puzzleSolution->addPuzzlePieceVertically($firstPiece);
                $puzzleSolution->addPuzzlePieceVertically($secondPiece);
                return $puzzleSolution;
            }
            if ($firstPiece->matchHorizontally($secondPiece)) {
                $puzzleSolution->addPuzzlePieceHorizontally($firstPiece);
                $puzzleSolution->addPuzzlePieceHorizontally($secondPiece);
                return $puzzleSolution;
            }
            if ($secondPiece->matchHorizontally($firstPiece)) {
                $puzzleSolution->addPuzzlePieceHorizontally($secondPiece);
                $puzzleSolution->addPuzzlePieceHorizontally($firstPiece);
                return $puzzleSolution;
            }

            $puzzleSolution->addPuzzlePieceVertically($secondPiece);
            $puzzleSolution->addPuzzlePieceVertically($firstPiece);
            return $puzzleSolution;
        }

        if (count($puzzlePieces) === 3) {
            $puzzleSolution->addPuzzlePieceHorizontally($puzzlePieces[0]);
            $puzzleSolution->addPuzzlePieceHorizontally($puzzlePieces[1]);
            $puzzleSolution->addPuzzlePieceHorizontally($puzzlePieces[2]);
            return $puzzleSolution;
        }

        return null;
    }
}
