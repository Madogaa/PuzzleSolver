<?php

declare(strict_types=1);

namespace App\PuzzleSolver;

use App\PuzzleSolver\PuzzleSolution\NoPuzzleSolutionException;
use App\PuzzleSolver\PuzzleSolution\PuzzleSolution;

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
            if (!$puzzleDashboard->canPuzzlePieceBeAddedRotating($puzzlePiece)) {
                continue;
            }

            $puzzleDashboard->addPuzzlePiece($puzzlePiece);
            $this->buildPuzzleSolutionRecursively($puzzleDashboard);
            $puzzleDashboard->removePuzzlePiece($puzzlePiece);
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
