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
            $puzzleSolution = new PuzzleSolution([]);
            $firstPiece = $puzzlePieces[0];
            $puzzleSolution->addPuzzlePieceHorizontally($firstPiece);
            return $puzzleSolution;
        }

        if (count($puzzlePieces) === 2) {
            $puzzleSolution = new PuzzleSolution([]);
            $firstPiece = $puzzlePieces[0];
            $secondPiece = $puzzlePieces[1];
            if ($firstPiece->matchVertically($secondPiece)) {
                $puzzleSolution->addPuzzlePieceVertically($firstPiece);
                $puzzleSolution->addPuzzlePieceVertically($secondPiece);
                return $puzzleSolution;
            } elseif ($firstPiece->matchHorizontally($secondPiece)) {
                $puzzleSolution->addPuzzlePieceHorizontally($firstPiece);
                $puzzleSolution->addPuzzlePieceHorizontally($secondPiece);
                return $puzzleSolution;
            } elseif ($secondPiece->matchHorizontally($firstPiece)) {
                $puzzleSolution->addPuzzlePieceHorizontally($secondPiece);
                $puzzleSolution->addPuzzlePieceHorizontally($firstPiece);
                return $puzzleSolution;
            }

            $puzzleSolution->addPuzzlePieceVertically($secondPiece);
            $puzzleSolution->addPuzzlePieceVertically($firstPiece);
            return $puzzleSolution;
        }

        if (count($puzzlePieces) === 3) {
            $puzzleSolution = new PuzzleSolution([]);
            $firstPiece = $puzzlePieces[0];
            $secondPiece = $puzzlePieces[1];
            $thirdPiece = $puzzlePieces[2];
            $puzzleSolution->addPuzzlePieceHorizontally($firstPiece);
            $puzzleSolution->addPuzzlePieceHorizontally($secondPiece);
            $puzzleSolution->addPuzzlePieceHorizontally($thirdPiece);
            return $puzzleSolution;
        }

        return null;
    }
}
