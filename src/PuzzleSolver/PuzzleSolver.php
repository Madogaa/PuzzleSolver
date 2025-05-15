<?php

declare(strict_types=1);

namespace App\PuzzleSolver;

use App\PuzzleSolver\PuzzlePiece\PuzzlePiece;
use App\PuzzleSolver\PuzzleSolution\NoPuzzleSolutionException;
use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;
use App\PuzzleSolver\PuzzleValidator\PuzzlePieceValidator;

final class PuzzleSolver
{
    private array $puzzleSolutions = [];
    /**
     * @throws NoPuzzleSolutionException
     *
     * @return string[]
     */
    public function solve(string $puzzleContext): array
    {
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);

        $this->buildPuzzleSolutionRecursively($puzzleDashboard);
        if ($this->puzzleSolutions === []) {
            throw new NoPuzzleSolutionException();
        }

        return $this->formatPuzzleSolutions();
    }

    private function buildPuzzleSolutionRecursively(PuzzleDashboard $puzzleDashboard): void
    {
        if ($puzzleDashboard->puzzleSolution->isSolved()) {
            $this->puzzleSolutions[] = clone $puzzleDashboard->puzzleSolution;
            return;
        }

        foreach ($puzzleDashboard->availablePuzzlePieces as $puzzlePiece) {
            for ($i = 0; $i <= PuzzlePiece::MAX_ROTATIONS; ++$i) {
                if (PuzzlePieceValidator::canPuzzlePieceBeAddedToSolution($puzzleDashboard->puzzleSolution, $puzzlePiece)) {
                    $puzzleDashboard->addPuzzlePiece($puzzlePiece);
                    $this->buildPuzzleSolutionRecursively($puzzleDashboard);
                    $puzzleDashboard->removePuzzlePiece($puzzlePiece);
                }

                $puzzlePiece->rotate();
            }

            $puzzlePiece->resetRotation();
        }
    }

    /**
     * @return string[]
     */
    private function formatPuzzleSolutions(): array
    {
        return array_map(
            static fn (PuzzleSolution $puzzleSolution): string => PuzzleSolution::format($puzzleSolution),
            $this->puzzleSolutions
        );
    }
}
