<?php

declare(strict_types=1);

namespace App;

final class PuzzleSolver
{
    private array $puzzleSolutions = [];
    /**
     * @throws NoPuzzleSolutionException
     */
    public function solve(string $puzzleContext): string
    {
        $puzzleDashboard = PuzzleDashboard::parse($puzzleContext);

        $this->buildPuzzleSolutionRecursively($puzzleDashboard);
        if ($this->puzzleSolutions === []) {
            throw new NoPuzzleSolutionException();
        }

        return PuzzleSolution::format($this->puzzleSolutions[0]);
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
}
