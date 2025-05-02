<?php

declare(strict_types=1);

namespace App;

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
        if ($puzzleDashboard->isSolved()) {
            $this->puzzleSolutions[] = clone $puzzleDashboard->puzzleSolution;
            return;
        }

        foreach ($puzzleDashboard->availablePuzzlePieces as $puzzlePiece) {
            if (!$puzzleDashboard->canPuzzlePieceBeAddedWithRotations($puzzlePiece)) {
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
