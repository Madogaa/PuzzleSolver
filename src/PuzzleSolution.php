<?php

declare(strict_types=1);

namespace App;

use function count;

final class PuzzleSolution
{
    /**
     * @param int[][] $puzzleSolutionIndex
     */
    public function __construct(
        public array $puzzleSolutionIndex
    ) {
    }

    public static function format(?self $puzzleSolution): string
    {
        $puzzleSolutionIndex = $puzzleSolution->puzzleSolutionIndex;
        $puzzleSolutionIndexRows = [];
        foreach ($puzzleSolutionIndex as $puzzleSolution) {
            $puzzleSolutionIndexRows[] = implode(' ', $puzzleSolution);
        }

        return implode("\n", $puzzleSolutionIndexRows);
    }

    public function addPuzzlePieceHorizontally(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[0][] = $puzzlePiece->id;
    }

    public function addPuzzlePieceVertically(PuzzlePiece $puzzlePiece): void
    {
        $this->puzzleSolutionIndex[][] = $puzzlePiece->id;
    }

    public function solvedPiecesCount(): int
    {
        return array_reduce(
            $this->puzzleSolutionIndex,
            static fn (int $carry, array $row) => $carry + count($row),
            0
        );
    }
}
