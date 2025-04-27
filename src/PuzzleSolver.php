<?php

declare(strict_types=1);

namespace App;

use function count;

final readonly class PuzzleSolver
{
    public function solve(string $puzzleContext): string
    {
        $puzzleConfiguration = PuzzleConfiguration::parse($puzzleContext);

        $puzzleSolutionIndex = self::buildPuzzleSolution($puzzleConfiguration);

        return PuzzleSolution::format($puzzleSolutionIndex);
    }

    private static function buildPuzzleSolution(PuzzleConfiguration $puzzleConfiguration): ?PuzzleSolution
    {
        $puzzlePieces = $puzzleConfiguration->puzzlePieces;
        $puzzleSolution = new PuzzleSolution([]);

        if (count($puzzlePieces) === 1) {
            $puzzleSolution->addPuzzlePieceAtNewRow($puzzlePieces[0]);
            return $puzzleSolution;
        }

        if (count($puzzlePieces) === 2) {
            $firstPiece = $puzzlePieces[0];
            $secondPiece = $puzzlePieces[1];
            if ($firstPiece->matchVertically($secondPiece)) {
                $puzzleConfiguration->addPuzzlePiece($puzzleSolution, $firstPiece);
                $puzzleConfiguration->addPuzzlePiece($puzzleSolution, $secondPiece);
                return $puzzleSolution;
            }
            if ($firstPiece->matchHorizontally($secondPiece)) {
                $puzzleConfiguration->addPuzzlePiece($puzzleSolution, $firstPiece);
                $puzzleConfiguration->addPuzzlePiece($puzzleSolution, $secondPiece);
                return $puzzleSolution;
            }
            if ($secondPiece->matchHorizontally($firstPiece)) {
                $puzzleConfiguration->addPuzzlePiece($puzzleSolution, $secondPiece);
                $puzzleConfiguration->addPuzzlePiece($puzzleSolution, $firstPiece);
                return $puzzleSolution;
            }

            $puzzleConfiguration->addPuzzlePiece($puzzleSolution, $secondPiece);
            $puzzleConfiguration->addPuzzlePiece($puzzleSolution, $firstPiece);
            return $puzzleSolution;
        }

        if (count($puzzlePieces) === 3) {
            $puzzleConfiguration->addPuzzlePiece($puzzleSolution, $puzzlePieces[0]);
            $puzzleConfiguration->addPuzzlePiece($puzzleSolution, $puzzlePieces[1]);
            $puzzleConfiguration->addPuzzlePiece($puzzleSolution, $puzzlePieces[2]);
            return $puzzleSolution;
        }

        return null;
    }
}
