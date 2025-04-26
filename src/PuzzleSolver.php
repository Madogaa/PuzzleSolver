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
                $puzzleSolution->addPuzzlePieceAtNewRow($firstPiece);
                $puzzleSolution->addPuzzlePieceAtNewRow($secondPiece);
                return $puzzleSolution;
            }
            if ($firstPiece->matchHorizontally($secondPiece)) {
                $puzzleSolution->addPuzzlePieceAtNewRow($firstPiece);
                $puzzleSolution->addPuzzlePieceAtSameRow($secondPiece);
                return $puzzleSolution;
            }
            if ($secondPiece->matchHorizontally($firstPiece)) {
                $puzzleSolution->addPuzzlePieceAtNewRow($secondPiece);
                $puzzleSolution->addPuzzlePieceAtSameRow($firstPiece);
                return $puzzleSolution;
            }

            $puzzleSolution->addPuzzlePieceAtNewRow($secondPiece);
            $puzzleSolution->addPuzzlePieceAtNewRow($firstPiece);
            return $puzzleSolution;
        }

        if (count($puzzlePieces) === 3) {
            $puzzleSolution->addPuzzlePieceAtNewRow($puzzlePieces[0]);
            $puzzleSolution->addPuzzlePieceAtSameRow($puzzlePieces[1]);
            $puzzleSolution->addPuzzlePieceAtSameRow($puzzlePieces[2]);
            return $puzzleSolution;
        }

        return null;
    }
}
